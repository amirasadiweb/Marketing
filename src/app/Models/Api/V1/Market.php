<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden=['updated_at','created_at','product_id','user_id','id','visit'];

    protected $appends=['product'];


//    public function getLinksAttribute()
//    {
//        return url('/') . '/' . $this->link;
//    }

    public function getProductAttribute()
    {
       return Product::select('title','description','picture')->where('id',$this->product_id)->get();
    }

    public function getLinkAttribute($value)
    {
       return $this['link']=url('/api/v1/visit') . '/' . $value;
    }

}
