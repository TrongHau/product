<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Helpers;
use Session;
use App\Models\User;
use App\Models\Roles;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ResetPasswordRequest;
use Illuminate\Support\Str;
use App\Helpers\Auth_SSO;

class CustomAuthController extends Controller
{
    public function index()
    {
        if(Auth::user())
            return redirect("/");
//        $prompt = isset($_GET['prompt']) ? $_GET['prompt'] : '';
//        return view('auth.login', compact('prompt'));
        $type = 'login';

        return view('auth.home_page', compact('type'));
    }

    public function callBack(Request $request) {
        if($request->code) {
            // get access token
            $url = env('DomainAuth').'/oauth/token';
            $data = [
                'grant_type' => 'authorization_code',
                'client_id' => env('ClientID'),
                'client_secret' => env('ClientSecret'),
                'redirect_uri' => env('APP_URL').'/callback',
                'code' => $request->code
            ];

            $response = Http::timeout(30)->asForm()->post($url, $data);

            if (!$response) {
                echo 'Login fail access token'; exit;
            }
            $respAuth = null;
            if ($response->successful()) {
                $respAuth = json_decode($response->body(), true);
            }
            // get user
            $respUser = Auth_SSO::getUser($respAuth['access_token']);
            if (!$respUser) {
                echo 'Login fail user'; exit;
            }
            $user = User::where('id', $respUser['id'])->where('email', $respUser['email'])->first();
            $now = Carbon::now('Asia/Ho_Chi_Minh');

            if($user) { // update user
                $user->name = $respUser['name'];
                $user->phone = $respUser['phone'];
                $user->last_login = $now->toDateTimeString();
                $user->refresh_token = $respAuth['refresh_token'];
                $user->save();
            }else{ // create user
                $user = User::create([
                    'id' => $respUser['id'],
                    'name' => $respUser['name'],
                    'email' => $respUser['email'],
                    'phone' => $respUser['phone'],
                    'refresh_token' => $respAuth['refresh_token'],
                ]);
                $role = Roles::where('slug', 'user')->first();
                $user->attachRole($role->id);
            }
            Auth::login($user, false);
            return redirect("/product");
        }else{
            echo 'Login fail'; exit;
        }
    }
    public function customLogin(Request $request)
    {
        if($request->_handler == 'login') {
            $validator = Validator::make(
                $request->all(),
                [
                    'email'                      => 'required|email',
                    'password'                      => 'required|min:8',
                ],
                [
                    'email.required'             => 'Nhập địa chỉ email',
                    'email.email'             => 'Nhập định dạng địa chỉ email',
                    'password.required'               => 'Nhập mật khẩu',
                ]
            );
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return redirect("/product");
            }
            return redirect("/login")->with('error', 'Tài khoản không chính xác')->withInput();
        }
        if($request->_handler == 'register') {
            $validator = Validator::make(
                $request->all(),
                [
                    'name'                      => 'required|min:2|max:30',
                    'email'                      => 'required|email',
                    'password'              => 'required|min:6|max:30|confirmed',
                    'password_confirmation' => 'required|same:password',
                ],
                [
                    'email.required'             => 'Nhập địa chỉ email',
                    'email.email'             => 'Nhập định dạng địa chỉ email',
                    'password.required'               => 'Nhập mật khẩu',
                ]
            );
            if ($validator->fails()) {
                return redirect("/login?type=register")->withErrors($validator)->withInput();
            }
            $data = $request->all();
            $check = $this->create($data);
            $role = Roles::where('slug', 'user')->first();
            $check->attachRole($role->id);
            Auth::login($check, false);
            if($check)
                return redirect("/product")->withSuccess('Đăng ký thành công');
        }
    }

    public function registration()
    {
        return view('auth.registration');
    }


    public function customRegistration(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'                      => 'required|min:2|max:30',
                'email'                      => 'required|email',
                'password'              => 'required|min:6|max:30|confirmed',
                'password_confirmation' => 'required|same:password',
            ],
            [
                'email.required'             => 'Nhập địa chỉ email',
                'email.email'             => 'Nhập định dạng địa chỉ email',
                'password.required'               => 'Nhập mật khẩu',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $check = $this->create($data);

        return redirect("dashboard")->withSuccess('You have signed-in');
    }


    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }


    public function signOut() {
        Session::flush();
        Auth::logout();

        return Redirect('/login?prompt=login');
    }
    public function resetPassword(Request $request) {
        $user = User::where('email', $request->email)->first();
        if(!$user) {
            return [
                'success' => true,
                'data' => [],
                'message' => 'Không tìm thấy email khớp với tài khoản'
            ];
        }
        $passwordReset = PasswordReset::updateOrCreate([
            'email' => $user->email,
        ], [
            'token' => Str::random(60),
        ], [
            'created_at' => date("Y-m-d H:i:s")
        ]);
        if ($passwordReset) {
            $user->notify(new ResetPasswordRequest($passwordReset->token));
        }
        return [
            'success' => true,
            'data' => [],
            'message' => 'Email láy lại mật khẩu đã gửi, vui lòng kiểm tra email'
        ];
    }
    public function reset(Request $request, $token)
    {
        $passwordReset = PasswordReset::where('token', $token)->firstOrFail();
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();

            return response()->json([
                'message' => 'This password reset token is invalid.',
            ], 422);
        }
        $user = User::where('email', $passwordReset->email)->firstOrFail();
        $updatePasswordUser = $user->update($request->only('password'));
        $passwordReset->delete();

        return response()->json([
            'success' => $updatePasswordUser,
        ]);
    }
}
