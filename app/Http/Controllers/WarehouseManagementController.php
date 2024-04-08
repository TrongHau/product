<?php

namespace App\Http\Controllers;

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
use App\Models\WarehouseModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use function Symfony\Component\Routing\Matcher\Dumper\export;

class WarehouseManagementController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $name = $request->name;
        $number_tax = $request->number_tax;
        $status = $request->status ?? 'all';
        $per_page = $request->per_page ?? 25;
        $search = [
            'name'         => $name,
            'number_tax'     => $number_tax,
            'status'          => $status,
        ];
        $warehouseList = WarehouseModel::where('user_id', Auth::user()->id)->where('is_deleted', 0)->orderby('id', 'desc');
        if($name) {
            $warehouseList = $warehouseList->where('name', 'like', '%'.$name.'%');
        }
        if($status != 'all') {
            $warehouseList = $warehouseList->where('status', $status);
        }

        $warehouseList = $warehouseList->paginate($per_page);

        return view('warehouseManagement.index', compact('name', 'status', 'search', 'warehouseList', 'per_page'));
    }
    public function edit(Request $request, $id) {
        $supplier = WarehouseModel::where('id', $id)->where('user_id', Auth::user()->id)->first();
        if(!$supplier) {
            return [
                'success' => false,
                'message' => 'Không tìm thấy nhà kho hàng',
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
                    'address'                      => 'required',
                ]
            );


            if ($validator->fails()) {
                Session::flash('error', 'Lỗi thông tin nhập kho hàng');
                return back();
            }
            WarehouseModel::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'contact' => $request->contact,
                'address' => $request->address,
                'status' => $request->status == 1 ? 1 : 0,
            ]);
            Session::flash('success', 'Thêm kho hàng thành công');
            return redirect('/warehouse');
        }elseif($request->action_input == 'edit'){
            $warehouse = WarehouseModel::where('id', $request->id)->where('user_id', Auth::user()->id)->first();
            if(!$warehouse) {
                Session::flash('error', 'Lỗi không thấy kho hàng');
                return back();
            };
            $validator = Validator::make(
                $request->all(),
                [
                    'name'                      => 'required',
                    'address'                      => 'required',
                ]
            );
            if ($validator->fails()) {
                Session::flash('error', 'Lỗi thông tin nhập kho hàng');
                return back();
            };
            $warehouse->name = $request->name;
            $warehouse->address = $request->address;
            $warehouse->contact = $request->contact;
            $warehouse->status = $request->status == 1 ? 1 : 0;
            $warehouse->save();
            Session::flash('success', 'Chỉnh sửa kho hàng thành công');
            return redirect('/warehouse');
        }
    }
    protected function defaultCurrency($str){
        return str_replace(',', '', $str);
    }
    public function delete(Request $request) {
        $ids = $request->id;
        if($ids) {
            $arrIds = explode(',', $ids);
            WarehouseModel::where('user_id', Auth::user()->id)->whereIn('id', $arrIds)->update([
                'is_deleted' => 1
            ]);
            Session::flash('success', 'Xóa kho hàng thành công');
            return Redirect::to(url()->previous());
        }
    }

}
