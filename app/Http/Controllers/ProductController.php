<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
//    CRUD
    public function index(){
        $product = Product::paginate(10); // Paginate with 10 users per page

        return response()->json($product);
    }
    public function show(string $id){
        try{
            $product = Product::where('id',$id)->first();
            return response()->json(['data'=>$product],200);
        } catch (Exception $exception){
            return response()->json(
                [
                'data' => [],
                'message' =>$exception->getMessage()
                ],
                $exception->getCode());
        }

    }
    public function store(StoreProductRequest $request)
    {
        $product = new Product();
        $product->productName = $request->input('productName');
        $product->category = $request->input('category');
        $product->unitPrice = $request->input('unitPrice');
        $product->quantityInStock = $request->input('quantityInStock',0);
        $product->imageURL = $request->input('imageURL','');
        $product->save();
        return response()->json([
           'message' => 'Product add' . $product
        ], 201);
    }
    public function update(Request $request, string $id): JsonResponse
    {
        try{
            $product = Product::where('id',$id)->first();
            if (empty($product)) {
                return response()->json(['not found'],404);
            }

            $input = $request->validate([
                'productName' => ['string','max:255'],
                'unitPrice' => ['integer'],
                'imageURL' => ['string'],
                'category' => ['string'],
                'quantityInStock' => ['numeric']
            ]);;
            $product->update($input);
            return response()->json(['newState'=>$product],200);
        } catch (Exception $exception){
            return response()->json(
                [
                    'data' => null,
                    'message' => $exception->getMessage()
                ],
               400);
        }
    }
    public function delete(string $id): JsonResponse
    {
//        Eloquent
        $product = Product::where('id',$id)->first();
        if (empty($product)) {
            return response()->json(['message' => 'Product does not exist.']);
        } else{
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully']);
        }
    }

//    Complex
    public function getProductByCategory(Request $request): JsonResponse{
        try{
            $categories = $request->input('category',[]);
            $product = DB::table('products')
                ->whereIn('category', $categories)
                ->get();
            if(count($product) > 0){
                return response()->json(['products'=>$product],200);
            }else{
                return response()->json(['No products'],200);
            }
        } catch (Exception $exception){
            return response()->json(
                [
                    'data' => null,
                    'message' =>$exception->getMessage()
                ],
                $exception->getCode());
        }

    }

}
