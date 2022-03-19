<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use Dotenv\Validator;
use App\Http\Resources\Product as ProductResource;
use function PHPUnit\Framework\isNull;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $product = Product::all();
        return $this->sendResponse(ProductResource::collection($product),
        'All products sent');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=>$this->name,
            'detail'=>$this->detail,
            'price'=>$this->price,
        ]);
        if($validator->fails()) {
            return $this->sendError('Please Validate error', $validator->errors());
        }
        $product = Product::create($input);
        return $this->sendResponse(new ProductResource($product),'Product created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $product = Product::find($id);
        if(isNull($product)) {
            return $this->sendError('Please not found');
        }
        return $this->sendResponse(new ProductResource($product),'Product found successfully');

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=>$this->name,
            'detail'=>$this->detail,
            'price'=>$this->price,
        ]);
        if($validator->fails()) {
            return $this->sendError('Please Validate error', $validator->errors());
        }
        $product->name = $input->name;
        $product->detail = $input->detail;
        $product->price = $input->price;

        return $this->sendResponse(new ProductResource($product),'Product updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
        return $this->sendResponse(new ProductResource($product),'Product deleted successfully');
    }
}
