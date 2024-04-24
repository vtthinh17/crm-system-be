<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $product = Product::paginate(10); // Paginate with 10 users per page

        return response()->json($product);
    }
    public function show(int $id){
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

    }
//    public function update(StoreProductRequest $request, string $id): JsonResponse
//    {
//        try{
//            $product = Product::where('id',$id)->first();
//            if (empty($product)) {
//                throw new Exception("Product does not exist.", ResponseAlias::HTTP_NOT_FOUND);
//            }
//            $validatedData = $request->validated();
//            $product->update($validatedData);
//            return response()->json(['newState'=>$product],200);
//        } catch (Exception $exception){
//            return response()->json(
//                [
//                    'data' => null,
//                    'message' => $exception->getMessage()
//                ],
//                $exception->getCode());
//        }
//    }

    public function update(Request $request, $id) {
        $product = Product::where('id',$id)->first();
        $product->update($request->all());
        return $product;
    }

    public function delete(string $id)
    {
        $product = Product::where('id',$id)->first();
        if (empty($product)) {
            return response()->json(['message' => 'Product does not exist.']);
        } else{
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully']);
        }
    }
}
