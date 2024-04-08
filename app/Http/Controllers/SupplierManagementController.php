<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use App\Models\EnterWarehouseModel;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\ProductModel;
use App\Models\BranchModel;
use App\Models\CategoryModel;
use App\Models\UnitModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use function Symfony\Component\Routing\Matcher\Dumper\export;

class SupplierManagementController extends Controller
{
    public function __construct() {
//        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $user = User::find(29);
        Auth::login($user);
        return redirect('/product');



        $name = $request->name;
        $number_tax = $request->number_tax;
        $status = $request->status ?? 'all';
        $per_page = $request->per_page ?? 25;
        $search = [
            'name'         => $name,
            'number_tax'     => $number_tax,
            'status'          => $status,
        ];
        $supplierList = SupplierModel::where('user_id', Auth::user()->id)->where('is_deleted', 0)->orderby('id', 'desc');
        if($name) {
            $supplierList = $supplierList->where('name', 'like', '%'.$name.'%');
        }
        if($number_tax) {
            $supplierList = $supplierList->where('number_tax', '%'.$number_tax.'%');
        }
        if($status != 'all') {
            $supplierList = $supplierList->where('status', $status);
        }

        $supplierList = $supplierList->paginate($per_page);

        return view('supplierManagement.index', compact('name', 'number_tax', 'status', 'search', 'supplierList', 'per_page'));
    }
    public function edit(Request $request, $id) {
        $supplier = SupplierModel::where('id', $id)->where('user_id', Auth::user()->id)->first();
        if(!$supplier) {
            return [
              'success' => false,
              'message' => 'Không tìm thấy nhà cung cấp',
            ];
        };
        return [
            'success' => true,
            'message' => '',
            'data' => $supplier->toArray()
        ];
    }
    public function store(Request $request) {
        if($request->action_input == 'create') {
            $validator = Validator::make(
                $request->all(),
                [
                    'name'                      => 'required',
                    'number_tax'                      => 'required',
                    'address'                      => 'required',
                ]
            );


            if ($validator->fails()) {
                Session::flash('error', 'Lỗi thông tin nhập nhà cung cấp');
                return back();
            }
            SupplierModel::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'number_tax' => $request->number_tax,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'contact' => $request->contact,
                'status' => $request->status == 1 ? 1 : 0,
            ]);
            Session::flash('success', 'Thêm nhà cung cấp thành công');
            return redirect('/supplier');
        }elseif($request->action_input == 'edit'){
            $supplier = SupplierModel::where('id', $request->id)->where('user_id', Auth::user()->id)->first();
            if(!$supplier) {
                Session::flash('error', 'Lỗi không thấy nhà cung cấp');
                return back();
            };
            $validator = Validator::make(
                $request->all(),
                [
                    'name'                      => 'required',
                    'number_tax'                      => 'required',
                    'address'                      => 'required',
                ]
            );
            if ($validator->fails()) {
                Session::flash('error', 'Lỗi thông tin nhập nhà cung cấp');
                return back();
            };
            $supplier->name = $request->name;
            $supplier->number_tax = $request->number_tax;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->contact = $request->contact;
            $supplier->status = $request->status == 1 ? 1 : 0;
            $supplier->save();
            Session::flash('success', 'Chỉnh sửa nhà cung cấp thành công');
            return redirect('/supplier');
        }
    }
    protected function defaultCurrency($str){
        return str_replace(',', '', $str);
    }
    public function delete(Request $request) {
        $ids = $request->id;
        if($ids) {
            $arrIds = explode(',', $ids);
            $suppliers = SupplierModel::where('user_id', Auth::user()->id)->whereIn('id', $arrIds)->update([
                'is_deleted' => 1
            ]);
            Session::flash('success', 'Xóa nhà cung cấp thành công');
            return Redirect::to(url()->previous());
        }
    }

}
