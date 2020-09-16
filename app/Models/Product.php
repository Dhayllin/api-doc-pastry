<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'id', 'name', 'price','photo'
     ];

     static function rules()
     {
         return [
             'name' => 'required|string|max:50',
             'price'=>'required|numeric',
             'photo' =>'image' //The file under validation must be an image (jpeg, png, bmp, gif, svg, or webp)
         ];
     }

}
