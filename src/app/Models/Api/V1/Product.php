<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=[];
    protected $hidden=['updated_at','created_at','deleted_at'];
    protected $appends=['full_Picture_path'];

    public function getFullPicturePathAttribute()
    {
        return asset('storage/app') . '/' . $this->picture;
    }

}
