<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
       'id', 'name', 'email', 'telephone', 'date_birth', 'address', 'complement','neighborhood','cep',
    ];

    static function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'email'=>'string|sometimes|required|unique:customers',
            'telephone'=>'required',
            'address'=>'required',
            'neighborhood'=>'required',
            'cep'=>'required',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'customer_id','id');
    }

}
