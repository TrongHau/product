<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use App\Models\EnterWarehouseModel;
use App\Models\WarehouseModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Validator;
use Jtlendon\Search\Models\UploadFile;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\ProductModel;
use App\Models\ProductAbleModel;
use App\Models\BranchModel;
use App\Models\InventoryModel;
use App\Models\HistoryInventoryModel;
use App\Models\CategoryModel;
use App\Models\UnitModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use function Symfony\Component\Routing\Matcher\Dumper\export;

class EnterWarehouseManagementController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $receipt_created_date = $request->receipt_created_date;
        $productName = $request->productName;
        $supplier_id = $request->supplier_id;
        $warehouse_id = $request->warehouse_id;
        $product = $request->product;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $start_date = $start_date ? $start_date : $now->clone()->subDays(7)->format('Y/m/d');
        $end_date = $end_date ? $end_date : $now->clone()->format('Y/m/d');
        $status = $request->status ?? 'all';
        $per_page = $request->per_page ?? 25;
        $search = [
            'receipt_created_date'         => $receipt_created_date,
            'supplier_id'         => $supplier_id,
            'warehouse_id'     => $warehouse_id,
            'product'     => $product,
            'start_date'     => $start_date,
            'end_date'     => $end_date,
            'productName'     => $productName,
            'status'          => $status,
        ];
        $warehouseList = WarehouseModel::where('user_id', Auth::user()->id)
            ->where('is_deleted', 0)
            ->where('status', 1)
            ->orderby('id', 'desc')->get();
        $supplierList = SupplierModel::where('user_id', Auth::user()->id)
            ->where('is_deleted', 0)
            ->where('status', 1)
            ->orderby('id', 'desc')->get();
        $enterWarehouseList = EnterWarehouseModel::where('user_id', Auth::user()->id)->orderby('id', 'desc');
        if($supplier_id && $supplier_id != 'all') {
            $enterWarehouseList->where('supplier_id', $supplier_id);
        }
        if($warehouse_id && $warehouse_id != 'all') {
            $enterWarehouseList->where('warehouse_id', $warehouse_id);
        }
        if($status && $status != 'all') {
            $enterWarehouseList->where('status', $status);
        }
        if($productName) {
            $productIds = ProductModel::where('is_deleted', 0)
                ->where('user_id', Auth::user()->id)
                ->where(function($query) use ($productName) {
                $query->where('name','like', "%$productName%")
                        ->orWhere('sku','like',"%$productName%");
            })->pluck('id')->toArray();
            if($productIds) {
                $enterWarehouseList->where(function ($q) use ($productIds) {
                    $q->whereHas('product', function ($query) use ($productIds) {
                        $query->whereIn('product_id', $productIds);
                    });
                });
            }else{
                $enterWarehouseList->where('id', 0); // k tìm thấy sản phẩm
            }
        }
        $enterWarehouseList->where('created_at','>=', $start_date . ' 00:00:00');
        $enterWarehouseList->where('created_at','<=', $end_date . ' 23:59:59');

        $enterWarehouseList = $enterWarehouseList->paginate($per_page);

        return view('enterWarehouseManagement.index', compact('status', 'productName', 'search', 'supplier_id', 'warehouse_id', 'supplierList', 'enterWarehouseList', 'per_page', 'start_date', 'end_date', 'warehouseList'));
    }
    public function create() {
        $warehouseList = WarehouseModel::where('user_id', Auth::user()->id)
            ->where('is_deleted', 0)
            ->where('status', 1)
            ->orderby('id', 'desc')->get();
        $supplierList = SupplierModel::where('user_id', Auth::user()->id)
            ->where('is_deleted', 0)
            ->where('status', 1)
            ->orderby('id', 'desc')->get();
        return view('enterWarehouseManagement.create', compact('supplierList', 'warehouseList'));
    }
    public function edit(Request $request, $id) {
        $enterWarehouse = EnterWarehouseModel::where('id', $id)->where('user_id', Auth::user()->id)->where('status', 1)->first();
        if(!$enterWarehouse) {
            Session::flash('error', 'Không tìm thấy phiếu nhập kho');
            return \redirect('/enter_warehouse');
        }
        $warehouseList = WarehouseModel::where('user_id', Auth::user()->id)
            ->where('is_deleted', 0)
            ->where('status', 1)
            ->orderby('id', 'desc')->get();
        $supplierList = SupplierModel::where('user_id', Auth::user()->id)
            ->where('is_deleted', 0)
            ->where('status', 1)
            ->orderby('id', 'desc')->get();
        $productAbles = ProductAbleModel::where('product_ables_id', $enterWarehouse->id)->get();
        $products = ProductModel::whereIn('id', $productAbles->pluck('product_id')->toArray())->get();
        return view('enterWarehouseManagement.edit', compact( 'enterWarehouse','warehouseList', 'supplierList', 'products', 'productAbles'));
    }
    public function detail(Request $request, $id) {
        $enterWarehouse = EnterWarehouseModel::where('id', $id)->where('user_id', Auth::user()->id)->first();
        if(!$enterWarehouse) {
            Session::flash('error', 'Không tìm thấy phiếu nhập kho');
            return \redirect('/enter_warehouse');
        }
        $warehouseList = WarehouseModel::where('user_id', Auth::user()->id)
            ->where('is_deleted', 0)
            ->where('status', 1)
            ->orderby('id', 'desc')->get();
        $supplierList = SupplierModel::where('user_id', Auth::user()->id)
            ->where('is_deleted', 0)
            ->where('status', 1)
            ->orderby('id', 'desc')->get();
        $productAbles = ProductAbleModel::where('product_ables_id', $enterWarehouse->id)->get();
        $products = ProductModel::whereIn('id', $productAbles->pluck('product_id')->toArray())->get();
        return view('enterWarehouseManagement.detail', compact( 'enterWarehouse','warehouseList', 'supplierList', 'products', 'productAbles'));
    }
    public function store(Request $request) {
        $validator = Validator::make(
            $request->all(),
            [
//                'purchase_date'                      => 'required|date',
//                'expired_date'                      => 'required|date|after_or_equal:purchase_date',
                'warehouse'                      => 'required',
                'supplier'                      => 'required',
            ],
            [
                'purchase_date.required' => 'Nhập ngày mua hàng',
                'expired_date.required' => 'Nhập ngày hết hạn',
                'expired_date.after_or_equal' => 'Ngày hết hạn lớn hơn ngày mua hàng',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $productList = $request->product ?? [];
        if(!$productList) {
            Session::flash('error', 'Lựa chọn thông tin sản phẩm để nhập kho');
            return back()->withErrors($validator)->withInput();
        }
        foreach($productList as $id) {
            if(!$_POST['cost_'.$id]) {
                $validator->errors()->add('cost_'.$id, 'Vui lòng nhập giá vốn');
            }
            if(!$_POST['price_'.$id]) {
                $validator->errors()->add('price_'.$id, 'Vui lòng nhập giá bán');
            }
            if(!$_POST['count_'.$id]) {
                $validator->errors()->add('count_'.$id, 'Vui lòng nhập số lượng');
            }
        }
        if ($validator->errors()->first()) {
            return back()->withErrors($validator)->withInput();
        }
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $result = EnterWarehouseModel::create([
           'user_id' => Auth::user()->id,
            'warehouse_id' => $request->warehouse,
            'supplier_id' => $request->supplier,
            'code_receipt' => $request->code_receipt,
            'shipment' => $request->shipment,
            'purchase_date' => $request->purchase_date,
            'expired_date' => $request->expired_date,
            'note' => $request->note,
            'status' => ($request->action_input == 'enter' ? 2 : ($request->action_input == 'create' ? 1 : 0)),
            'receipt_created_date' => ($request->action_input == 'enter' ? $now->format('Y-m-d') : null),
        ]);
        $inventoryArr = [];
        foreach($productList as $id) {
            $cost = str_replace(',', '', $_POST['cost_'.$id]);
            $price = str_replace(',', '', $_POST['price_'.$id]);
            $price_floor = $_POST['price_floor_'.$id] ? str_replace(',', '', $_POST['price_floor_'.$id]) : null;
            $count = str_replace(',', '', $_POST['count_'.$id]);
            $key = $id.'_'.$cost.'_'.$price.'_'.$price_floor;
            $inventoryArr[$key] = ($inventoryArr[$key] ?? 0) + (int)$count;
            ProductAbleModel::create([
                'product_id' => $id,
                'product_able_type' => 'App\Models\ProductModel',
                'product_ables_id' => $result->id,
                'cost' => $cost,
                'price' => $price,
                'price_floor' => $price_floor,
                'count' => $count,
            ]);
        }
        // tính tồn kho và lịch sửa nhập kho
        if($request->action_input == 'enter') {
            foreach ($inventoryArr as $key => $item) {
                $arr = explode('_', $key);
                $idProduct = $arr[0];
                $cost = $arr[1];
                $price = $arr[2];
                $price_floor = $arr[3] ? $arr[3] : null;
                $resultInv = InventoryModel::where('warehouse_id', $request->warehouse)
                    ->where('product_id', $idProduct)
                    ->where('cost', $cost)
                    ->where('price', $price)
                    ->where('price_floor', $price_floor)->first();
                if($resultInv) {
                    $resultInv->inv_number = $resultInv->inv_number + $item;
                    $resultInv->save();
                }else {
                    $resultInv = InventoryModel::create([
                        'warehouse_id' => $request->warehouse,
                        'product_id' => $idProduct,
                        'inv_number' => $item,
                        'cost' => $cost,
                        'price' => $price,
                        'price_floor' => null,
                    ]);
                }
                HistoryInventoryModel::create([
                    'inventory_id' => $resultInv->id,
                    'warehouse_id' => $request->warehouse,
                    'product_id' => $idProduct,
                    'inv_number' => $item,
                    'action' => 'enter_warehouse',
                    'user_id' => Auth::user()->id,
                ]);
            }
        }
        if($request->action_input == 'enter') {
            Session::flash('success', '<b>Tạo mới nhập kho</b> thành công');
        }elseif($request->action_input == 'create'){
            Session::flash('success', '<b>Đã lưu nháp</b> phiếu nhập kho thành');
        }else{
            Session::flash('success', '<b>Đã hủy</b> phiếu nhập kho');
        }
        return redirect('/enter_warehouse');
    }
    public function update(Request $request, $id) {
        $enterWarehouse = EnterWarehouseModel::where('id', $id)->where('status', 1)->first();
        if(!$enterWarehouse) {
            Session::flash('error', 'Không tìm thấy phiếu nhập kho');
            return back();
        }
        $validator = Validator::make(
            $request->all(),
            [
//                'purchase_date'                      => 'required|date',
//                'expired_date'                      => 'required|date|after_or_equal:purchase_date',
                'warehouse'                      => 'required',
                'supplier'                      => 'required',
            ],
            [
                'purchase_date.required' => 'Nhập ngày mua hàng',
                'expired_date.required' => 'Nhập ngày hết hạn',
                'expired_date.after_or_equal' => 'Ngày hết hạn lớn hơn ngày mua hàng',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $productList = $request->product ?? [];
        if(!$productList) {
            Session::flash('error', 'Lựa chọn thông tin sản phẩm để nhập kho');
            return back()->withErrors($validator)->withInput();
        }
        foreach($productList as $id) {
            if(!$_POST['cost_'.$id]) {
                $validator->errors()->add('cost_'.$id, 'Vui lòng nhập giá vốn');
            }
            if(!$_POST['price_'.$id]) {
                $validator->errors()->add('price_'.$id, 'Vui lòng nhập giá bán');
            }
            if(!$_POST['count_'.$id]) {
                $validator->errors()->add('count_'.$id, 'Vui lòng nhập số lượng');
            }
        }
        if ($validator->errors()->first()) {
            return back()->withErrors($validator)->withInput();
        }
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $enterWarehouse->warehouse_id = $request->warehouse;
        $enterWarehouse->supplier_id = $request->supplier;
        $enterWarehouse->code_receipt = $request->code_receipt;
        $enterWarehouse->shipment = $request->shipment;
        $enterWarehouse->purchase_date = $request->purchase_date;
        $enterWarehouse->expired_date = $request->expired_date;
        $enterWarehouse->note = $request->note;
        $enterWarehouse->status = ($request->action_input == 'enter' ? 2 : ($request->action_input == 'create' ? 1 : 0));
        $enterWarehouse->receipt_created_date = ($request->action_input == 'enter' ? $now->format('Y-m-d') : null);
        $enterWarehouse->save();
        ProductAbleModel::where('product_able_type', 'App\Models\ProductModel')
            ->where('product_ables_id', $enterWarehouse->id)
            ->delete();
        $inventoryArr = [];
        foreach($productList as $id) {
            $cost = str_replace(',', '', $_POST['cost_'.$id]);
            $price = str_replace(',', '', $_POST['price_'.$id]);
            $price_floor = $_POST['price_floor_'.$id] ? str_replace(',', '', $_POST['price_floor_'.$id]) : null;
            $count = str_replace(',', '', $_POST['count_'.$id]);
            $key = $id.'_'.$cost.'_'.$price.'_'.$price_floor;
            $inventoryArr[$key] = ($inventoryArr[$key] ?? 0) + $count;
            ProductAbleModel::create([
                'product_id' => $id,
                'product_able_type' => 'App\Models\ProductModel',
                'product_ables_id' => $enterWarehouse->id,
                'cost' => $cost,
                'price' => $price,
                'price_floor' => $price_floor,
                'count' => $count,
            ]);
        }
        // tính tồn kho và lịch sửa nhập kho
        if($request->action_input == 'enter') {
            foreach ($inventoryArr as $key => $item) {
                $arr = explode('_', $key);
                $idProduct = $arr[0];
                $cost = $arr[1];
                $price = $arr[2];
                $price_floor = $arr[3] ? $arr[3] : null;
                $resultInv = InventoryModel::where('warehouse_id', $request->warehouse)
                    ->where('product_id', $idProduct)
                    ->where('cost', $cost)
                    ->where('price', $price)
                    ->where('price_floor', $price_floor)->first();
                if($resultInv) {
                    $resultInv->inv_number = $resultInv->inv_number + $item;
                    $resultInv->save();
                }else {
                    $resultInv = InventoryModel::create([
                        'warehouse_id' => $request->warehouse,
                        'product_id' => $idProduct,
                        'inv_number' => $item,
                        'cost' => $cost,
                        'price' => $price,
                        'price_floor' => $price_floor,
                    ]);
                }
                HistoryInventoryModel::create([
                    'inventory_id' => $resultInv->id,
                    'warehouse_id' => $request->warehouse,
                    'product_id' => $idProduct,
                    'inv_number' => $item,
                    'action' => 'enter_warehouse',
                    'user_id' => Auth::user()->id,
                ]);
            }
        }
        if($request->action_input == 'enter') {
            Session::flash('success', '<b>Tạo mới nhập kho</b> thành công');
        }elseif($request->action_input == 'create'){
            Session::flash('success', '<b>Đã lưu nháp</b> phiếu nhập kho');
        }else{
            Session::flash('success', '<b>Đã hủy</b> phiếu nhập kho');
        }
        return redirect('/enter_warehouse');
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
