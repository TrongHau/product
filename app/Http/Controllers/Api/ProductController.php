<?php
namespace App\Http\Controllers\Api;

use App\Helpers\Auth_SSO;
use App\Models\ProductModel;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->header('authorization');
        if(!$token)
            return response()->json([
                'status' => false,
                'message' => 'token not found',
            ]);
        $result = Auth_SSO::verifyToken($token);
        if(!$result) {
            return response()->json([
                'status' => false,
                'message' => 'token verify fail',
            ]);
        }
        // get user
        $respUser = Auth_SSO::getUser($token, true);
        if (!$respUser) {
            echo 'Login fail user'; exit;
        }
        $user_id = $respUser['id'];
        $product_id =$request->product_id ?? '';
        $product_sku =$request->sku ?? '';
        $page_size = $request->page_size ?? 20;
        $products = ProductModel::where('status', 1)->where('is_deleted', 0)->where('user_id', $user_id);
        if($product_id) {
            $products->where('id', $product_id);
        }
        if($product_sku) {
            $products->where('sku', $product_sku);
        }

        $products = $products->paginate($page_size);
        $result = [];
        foreach ($products as &$item) {
            $p['id'] = $item->id;
            $p['category'] = $item->category->name;
            $p['unit'] = $item->unit->name;
            $p['branch'] = $item->branch->name;
            $p['name'] = $item->name;
            $p['sku'] = $item->sku;
            $p['barcode'] = $item->barcode;
            $p['weight'] = $item->weight;
            $p['cost'] = $item->cost;
            $p['price'] = $item->price;
            $p['description'] = $item->description;
            $p['tag_live_stream'] = $item->tag_live_stream ? explode('||', $item->tag_live_stream) : [];
            $p['properties'] = $item->properties ? explode('|', $item->properties) : [];
            $inventoryProd = \App\Models\InventoryModel::select(\DB::raw('sum(inv_number) as inv_number, product_id'))->where('product_id', $item->id)->groupBy('product_id')->pluck('inv_number')->first() ?? 0;
            $p['inv_number'] = $inventoryProd;
            $result[] = $p;
        }
        $products = $products->toArray();
        return response()->json([
            'current_page' => $products['current_page'] ?? '',
            'per_page' => $products['per_page'] ?? '',
            'total' => $products['total'] ?? '',
            'data' => $result,
        ]);
    }
}
