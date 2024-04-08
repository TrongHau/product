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
use App\Models\InventoryModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use function PHPUnit\Framework\result;
use function Symfony\Component\Routing\Matcher\Dumper\export;

class ProductManagementController extends Controller
{
    public function __construct() {
//        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $name = $request->name;
        $category = $request->category;
        $branch = $request->branch;
        $status = $request->status ?? 'all';
        $properties = $request->properties;
        $per_page = $request->per_page ?? 25;
        $categoryList = CategoryModel::orderby('id', 'desc')->get();
        $branchList = BranchModel::orderby('id', 'desc')->get();
        $unitList = UnitModel::orderby('id', 'desc')->get();
        $search = [
            'name'         => $name,
            'category'               => $category,
            'branch'          => $branch,
            'status'          => $status,
            'properties'          => $properties,
        ];
        $productList = ProductModel::where('is_deleted', 0)->where('user_id', Auth::user()->id)->orderby('id', 'desc');
        if($name) {
            $productList = $productList->where(function($q) use ($name) {
                $q->where('name', 'like', "%$name%")
                    ->orWhere('sku', 'like', "%$name%");
            });
        }
        if($category && $category != 'all') {
            $productList = $productList->where('category_id', $category);
        }
        if($branch && $branch != 'all') {
            $productList = $productList->where('branch_id', $branch);
        }
        if($status != 'all') {
            $productList = $productList->where('status', $status);
        }
        if($properties && $properties != 'all') {
            if($properties == 1) {
                $productList = $productList->WhereNotNull('parent');
            }else{
                $productList = $productList->whereNull('parent');
            }
        }
        $productList = $productList->paginate($per_page);

        return view('productManagement.index', compact('categoryList', 'branchList', 'unitList',
        'name', 'category', 'branch', 'status', 'search', 'productList', 'per_page', 'properties'));
    }
    public function create(Request $request) {
        $categoryList = CategoryModel::orderby('id', 'desc')->get();
        $branchList = BranchModel::orderby('id', 'desc')->get();
        $unitList = UnitModel::orderby('id', 'desc')->get();
        return view('productManagement.create', compact('categoryList', 'branchList', 'unitList'));
    }
    public function edit($id) {
        $product = ProductModel::where('id', $id)->where('is_deleted', 0)->first();
        $categoryList = CategoryModel::orderby('id', 'desc')->get();
        $branchList = BranchModel::orderby('id', 'desc')->get();
        $unitList = UnitModel::orderby('id', 'desc')->get();
        return view('productManagement.edit', compact( 'product','categoryList', 'branchList', 'unitList'));
    }
    public function detail($id) {
        $product = ProductModel::find($id);
        $relateProduct = ProductModel::where('user_id', Auth::user()->id)
            ->where('parent', $product->parent)
            ->where('is_deleted', 0)
            ->where('id', '!=', $product->id)
            ->select('name', 'id', 'sku')->get();
        $inventoryProd = InventoryModel::where('product_id', $product->id)->with('warehouse')->get();
        return view('productManagement.detail', compact( 'product', 'relateProduct', 'inventoryProd'));
    }
    public function store(Request $request) {
        if($request->action == 'branch'){
            return $this->createBranch($request);
        }elseif($request->action == 'category') {
            return $this->createCategory($request);
        }elseif($request->action == 'unit') {
            return $this->createUnit($request);
        }
        $validator = Validator::make(
            $request->all(),
            [
                'name'                      => 'required|max:100',
                'unit'                      => 'required',
                'category'                      => 'required',
                'sku'                      => 'required|unique:product',
                'weight' => 'required|regex:/^([0-9]+.)*[0-9]+$/|min:0|max:9999',
                'cost'           => 'required|min:0|max:99999999',
                'price'           => 'required|min:0|max:99999999',
            ],
            [
                'name.required'             => 'Nhập tên sản phẩm',
                'unit.required'             => 'Nhập đơn vị',
                'category.required'             => 'Nhập danh mục',
                'branch.required'             => 'Nhập thương hiệu',
                'sku.required'             => 'Nhập mã SKU',
                'sku.unique'             => 'Mã SKU đã tồn tại',
                'weight.regex'               => 'Trọng lượng phải số nguyên dương và thập phân dấu .',
                'weight.min'               => 'Trọng lượng phải lớn hơn 0',
                'weight.required'       => 'Nhập khối lượng',
                'weight.integer'       => 'Khối lượng phải là số',

                'cost.min'               => 'Giá vốn phải lớn hơn 0',
                'cost.required'       => 'Nhập Giá vốn',

                'price.min'               => 'Giá bán phải lớn hơn 0',
                'price.required'       => 'Nhập Giá bán',
            ]
        );


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $countProp = (int)($request->count_properties_prod ?? 0);
        if($countProp > 0) {
            $parentId = time();
            $product = [];
            for($i = 1; $i <= $countProp; $i ++) {
                $name = $_POST['properties_prod_name_'.$i] ?? '';
                $sku = $_POST['properties_prod_sku_'.$i] ?? '';
                $barcode = $_POST['properties_prod_barcode_'.$i] ?? '';
                $cost = $_POST['properties_prod_cost_'.$i] ?? '';
                $price = $_POST['properties_prod_price_'.$i] ?? '';
                $properties = $_POST['properties_'.$i] ?? '';
                if(!$name) {
                    $validator->errors()->add('properties_prod_name_'.$i, 'Nhập tên sản phẩm biến thể');
                    return back()->withErrors($validator)->withInput();
                }
                if(!$sku) {
                    $validator->errors()->add('properties_prod_sku_'.$i, 'Nhập mã phẩm SKU biến thể');
                    return back()->withErrors($validator)->withInput();
                }
                if(!$cost) {
                    $validator->errors()->add('properties_prod_cost_'.$i, 'Nhập giá vốn biến thể');
                    return back()->withErrors($validator)->withInput();
                }
                if(!$price) {
                    $validator->errors()->add('properties_prod_price_'.$i, 'Nhập giá bán biến thể');
                    return back()->withErrors($validator)->withInput();
                }
                if((int)$this->defaultCurrency($cost) <= 0) {
                    $validator->errors()->add('properties_prod_cost_'.$i, 'Giá vốn là số nguyên dương và lớn hơn 0');
                    return back()->withErrors($validator)->withInput();
                }
                if((int)$this->defaultCurrency($price) <= 0) {
                    $validator->errors()->add('properties_prod_price_'.$i, 'Giá bán là số nguyên dương và lớn hơn 0');
                    return back()->withErrors($validator)->withInput();
                }
                $skuExists = ProductModel::where('sku', $sku)->first();
                if($skuExists) {
                    $validator->errors()->add('properties_prod_sku_'.$i, 'Mã SKU này đã tồn tại');
                    return back()->withErrors($validator)->withInput();
                }
                $product = [
                    'name' => $name,
                    'parent' => $parentId,
                    'status' => $request->status,
                    'sku' => $sku,
                    'barcode' => $barcode,
                    'weight' => str_replace(',', '.', $request->weight),
                    'category_id' => $request->category,
                    'unit_id' => $request->unit,
                    'branch_id' => $request->branch,
                    'user_id' => Auth::user()->id,
                    'cost' => $this->defaultCurrency($cost),
                    'price' => $this->defaultCurrency($price),
                    'tag_live_stream' => $request->tag_live_stream,
                    'properties' => $properties,
                    'description' => $_POST['content'],
                    'image' => $this->saveImage($request),
                ];
                ProductModel::create($product);
            }
        }else{
            if((int)$this->defaultCurrency($request->cost) <= 0) {
                $validator->errors()->add('cost', 'Giá vốn là số nguyên dương và lớn hơn 0');
                return back()->withErrors($validator)->withInput();
            }
            if((int)$this->defaultCurrency($request->price) <= 0) {
                $validator->errors()->add('price', 'Giá bán là số nguyên dương và lớn hơn 0');
                return back()->withErrors($validator)->withInput();
            }
            $product = [
                'name' => $request->name,
                'status' => $request->status,
                'sku' => $request->sku,
                'barcode' => $request->barcode,
                'weight' => str_replace(',', '.', $request->weight),
                'category_id' => $request->category,
                'unit_id' => $request->unit,
                'branch_id' => $request->branch,
                'user_id' => Auth::user()->id,
                'cost' => $this->defaultCurrency($request->cost),
                'price' => $this->defaultCurrency($request->price),
                'tag_live_stream' => $request->tag_live_stream,
                'description' => $_POST['content'],
                'image' => $this->saveImage($request),
            ];
            ProductModel::create($product);
        }


        Session::flash('success', '<b>Thêm sản phẩm</b> thành công');
        return redirect('/product');
    }
    public function update(Request $request, $id) {
        if($request->action == 'branch'){
            return $this->createBranch($request);
        }elseif($request->action == 'category') {
            return $this->createCategory($request);
        }elseif($request->action == 'unit') {
            return $this->createUnit($request);
        }
        $product = ProductModel::where('id', $id)->where('is_deleted', 0)->first();
        $validator = Validator::make(
            $request->all(),
            [
                'name'                      => 'required|max:100',
                'unit'                      => 'required',
                'category'                      => 'required',
                'sku'                      => 'required|unique:product,sku,'.$id,
                'weight' => 'required|regex:/^([0-9]+.)*[0-9]+$/|min:0|max:9999',
                'cost'           => 'required|min:0|max:99999999',
                'price'           => 'required|min:0|max:99999999',
            ],
            [
                'unit.required'             => 'Nhập đơn vị',
                'category.required'             => 'Nhập danh mục',
                'branch.required'             => 'Nhập thương hiệu',
                'name.required'             => 'Nhập tên sản phẩm',
                'sku.required'             => 'Nhập mã SKU',
                'sku.unique'             => 'Mã SKU đã tồn tại',
                'weight.regex'               => 'Trọng lượng phải số nguyên dương và thập phân dấu .',
                'weight.min'               => 'Trọng lượng phải lớn hơn 0',
                'weight.required'       => 'Nhập khối lượng',
                'weight.integer'       => 'Khối lượng phải là số',

                'cost.min'               => 'Giá vốn phải lớn hơn 0',
                'cost.required'       => 'Nhập Giá vốn',

                'price.min'               => 'Giá bán phải lớn hơn 0',
                'price.required'       => 'Nhập Giá bán',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if((int)$this->defaultCurrency($request->cost) <= 0) {
            $validator->errors()->add('cost', 'Giá vốn là số nguyên dương và lớn hơn 0');
            return back()->withErrors($validator)->withInput();
        }
        if((int)$this->defaultCurrency($request->price) <= 0) {
            $validator->errors()->add('price', 'Giá bán là số nguyên dương và lớn hơn 0');
            return back()->withErrors($validator)->withInput();
        }
        $properties = $product->properties;
        if($properties) {
            $properties = explode('|', $properties);
            $properties_update = [];
            foreach($properties as $key => $item) {
                if(!$_POST['properties_name_' . $key]) {
                    $validator->errors()->add('properties_name_'. $key, 'Tên thuộc tính không được để trống');
                    return back()->withErrors($validator)->withInput();
                }
                if(!$_POST['properties_value_' . $key]) {
                    $validator->errors()->add('properties_value_'. $key, 'Giá trị thuộc tính không được để trống');
                    return back()->withErrors($validator)->withInput();
                }
                $properties_update[] = $_POST['properties_name_' . $key].':'.$_POST['properties_value_' . $key];
            }
            $product->properties = implode('|', $properties_update);
        }
        $oldImage = $product->image;
        $newImage = $this->saveImage($request);
        $product->name = $request->name;
        $product->status = $request->status;
        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->weight = str_replace(',', '.', $request->weight);
        $product->category_id = $request->category;
        $product->unit_id = $request->unit;
        $product->branch_id = $request->branch;
        $product->cost = $this->defaultCurrency($request->cost);
        $product->price = $this->defaultCurrency($request->price);
        $product->tag_live_stream = $request->tag_live_stream;
        $product->description = $_POST['content'];
        $product->image = $newImage;
        $product->save();

        // delete link old image
        if($oldImage) {
            $oldImage = explode(',', $oldImage);
            $newImage = explode(',', $newImage);
            if(count($newImage) == 0) {
                foreach ($oldImage as $img) {
                    $fileImage = storage_path('app/public'.str_replace('/storage', '', $img));
                    if (file_exists($fileImage)) {
                        unlink($fileImage);
                    }
                }
            }else{
                foreach ($oldImage as $img) {
                    if(!in_array($img, $newImage)) {
                        $fileImage = storage_path('app/public'.str_replace('/storage', '', $img));
                        if (file_exists($fileImage)) {
                            unlink($fileImage);
                        }
                    }
                }
            }

        }

        Session::flash('success', 'Chỉnh sửa sản phẩm thành công');
        return redirect('/product');
    }
    protected function defaultCurrency($str){
        return str_replace(',', '', $str);
    }
    protected function saveImage($request) {
        $urlImageArr = [];
        $uploaded_files = $request->uploaded_files;
        if($uploaded_files) {
            foreach ($uploaded_files as $item) {
                if(strpos($item, '/storage/images') === false) {
                    $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $item));
                    $fileName = rand(0, 999999) . '_' . time() . '.jpg';
                    $savePath = storage_path('app/public/images/' . Auth::user()->id . '/');
                    if (!file_exists($savePath)) {
                        mkdir($savePath . $fileName, 0777, true);
                    }
                    Storage::put('public/images/'.Auth::user()->id.'/'.$fileName, $imageData);
                    $url = '/storage/images/'.Auth::user()->id.'/'.$fileName;
                    $urlImageArr[] = $url;
                }else{
                    $urlImageArr[] = $item;
                }
            }
        }
        return implode(',', $urlImageArr);
    }
    public function delete(Request $request) {
        $ids = $request->id;
        if($ids) {
            $arrIds = explode(',', $ids);
            $products = ProductModel::where('user_id', Auth::user()->id)->whereIn('id', $arrIds)->get();
            foreach($products as $item) {
//                if($item->image) {
//                    $images = explode(',', $item->image);
//                    foreach($images as $img) {
//                        $fileImage = storage_path('app/public'.str_replace('/storage', '', $img));
//                        if (file_exists($fileImage)) {
//                            unlink($fileImage);
//                        }
//                    }
//                }
                $item->is_deleted = 1;
                $item->save();
            }
            Session::flash('success', 'Xóa sản phẩm thành công');
            return Redirect::to(url()->previous());
        }
    }
    public function createBranch($request) {
        $validator = Validator::make(
            $request->all(),
            [
                'name_branch_modal'                      => 'required|max:100',
            ],
            [
                'name_branch_modal.required'             => 'Nhập tên thương hiệu',
                'name_branch_modal.max'             => 'Tên thương hiệu quá dài',
            ]
        );
        if ($validator->fails()) {
            Session::flash('error', '<b>Lỗi</b> '.$validator->errors()->first());
            return back()->withInput();;
        }
        BranchModel::create([
            'name' => $request->name_branch_modal
        ]);
        return back()->withInput();
    }
    public function createUnit($request) {
        $validator = Validator::make(
            $request->all(),
            [
                'name_unit_modal'                      => 'required|max:100',
            ],
            [
                'name_unit_modal.required'             => 'Nhập tên đơn vị',
                'name_unit_modal.max'             => 'Tên đơn vị quá dài',
            ]
        );
        if ($validator->fails()) {
            Session::flash('error', '<b>Lỗi</b> '.$validator->errors()->first());
            return back()->withInput();;
        }
        UnitModel::create([
            'name' => $request->name_unit_modal
        ]);
        return back()->withInput();
    }
    public function createCategory($request) {
        $validator = Validator::make(
            $request->all(),
            [
                'name_category_modal'                      => 'required|max:100',
            ],
            [
                'name_category_modal.required'             => 'Nhập tên danh mục',
                'name_category_modal.max'             => 'Tên danh mục quá dài',
            ]
        );
        if ($validator->fails()) {
            Session::flash('error', '<b>Lỗi</b> '.$validator->errors()->first());
            return back()->withInput();;
        }
        CategoryModel::create([
            'name' => $request->name_category_modal
        ]);
        return back()->withInput();
    }
    public function search(Request $request) {
        $name = $request->key;
        $not_ids = $request->not_ids ?? [];
        $productList = ProductModel::where('user_id', Auth::user()->id)
            ->where('is_deleted', 0)
            ->where('status', 1)
            ->where(function($q) use ($name) {
                $q->where('name', 'like', "%$name%")
                  ->orWhere('sku', 'like', "%$name%");
                });
        if($not_ids)
            $productList->whereNotIn('id', $not_ids);
        $productList = $productList->orderBy('id', 'desc')->get();
        return view('ajax.product', compact('productList'))->render();
    }
    public function detail_search(Request $request) {
        $product = ProductModel::where('id', $request->id)
            ->where('is_deleted', 0)
            ->where('status', 1)
            ->where('user_id', Auth::user()->id)
            ->first();
        return view('ajax.product_detail', compact('product'))->render();
    }
}
