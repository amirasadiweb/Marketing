<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BasicController;
use App\Models\Api\V1\Product;
use Illuminate\Http\Request;

class ProductsController extends BasicController
{

    /**
     * @return mixed
     */
    public function show()
    {
        return Product::get();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try{

            $data=$this->validateRequest('create');
            $picture=$request->file('picture')->store('marketing');
            $data['picture']=$picture;
            Product::create($data);

            return $this->sendResponse($data, 'Success');
        }
        catch (\Exception $exception) {

            return $this->sendError('Operation Failed', $exception->getMessage(), 500);
        }

    }


    /**
     * @param Product $product
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Product $product,Request $request)
    {
        try{

            if($request->hasFile('picture')){
                $picture=$request->file('picture')->store('marketing');
                $data=$this->validateRequest('update');
                $data['picture']=$picture;
            }else{
                $data=$this->validateRequest('update');
            }

            $product->update($data);

            return $this->sendResponse($product, 'عملیات با موفقیت انجام شد');

        }
        catch (\Exception $exception) {
            return $this->sendError('Operation Failed', $exception->getMessage(), 500);
        }
    }



    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy (Product $product)
    {
        try{
            $product->delete();
            return $this->sendResponse($product, 'Success Soft Delete');
        }
        catch (\Exception $exception) {

            return $this->sendError('Operation Failed', $exception->getMessage(), 500);
        }
    }



    /**
     * @param $action
     * @return array
     */
    protected function validateRequest($action)
    {

        if($action=='create'){
            return request()->validate([
                'URL'=>'required',
                'title'=>'required',
                'description'=>'required',
                'picture'=>'required|mimes:jpeg,jpg,png|max:500000'
            ]);
        }else{
            return request()->validate([
                'URL'=>'',
                'title'=>'',
                'description'=>'',
                'picture'=>'mimes:jpeg,jpg,png|max:500000'
            ]);
        }

    }

}
