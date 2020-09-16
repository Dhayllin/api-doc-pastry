<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable =[
        'customer_id','product_ids'
    ];

    static function rules()
    {
        return [
            'customer_id' => 'required|numeric',
        ];
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

}
