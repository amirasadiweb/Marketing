<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Api\V1\Market;
use App\Models\Api\V1\Product;
use App\Models\Api\V1\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MarketsController extends Controller
{

    /**
     * @return string
     */
    public function show_market()
    {

        if(Gate::denies('marketing',))
            return 'Access Denied For Admin';

       return Product::where('user_id',Auth::user()->id)->orderBy('id','desc')->get();

    }

    /**
     * @return string
     */
    public function create_link()
    {

        if(Gate::denies('marketing',))
            return 'Access Denied For Admin';

        $data=$this->validateRequest('create');
        $data['user_id']=Auth::user()->id;


        $product=Product::where('id',$data['product_id'])->where('user_id',$data['user_id'])->count();

        if($product==0)
            return "You can't access this product";


        //share product
        $market=Market::create($data);
        return $market;

    }

    /**
     * @return mixed
     */
    public function show_social()
    {
       return Market::orderBy('id','desc')->get();
    }

    /**
     * @param $link
     * @return mixed
     */
    public function visit($link)
    {
        $market=Market::where('link',$link)->first();
        Visit::create([
            'user_id'=>$market->user_id,
            'product_id'=>$market->product_id,
            ]);

        return $market;
    }

    /**
     * @param Request $request
     */
    public function report(Request $request)
    {

    }




    /**
     * @param $action
     * @return array
     */
    protected function validateRequest($action)
    {

        if($action=='create'){
            return request()->validate([
                'product_id'=>'required',
                'user_id'=>'',
                'link'=>'required',
            ]);
        }else{
            return request()->validate([
                'product_id'=>'',
                'user_id'=>'',
                'link'=>'',
            ]);
        }

    }

}
