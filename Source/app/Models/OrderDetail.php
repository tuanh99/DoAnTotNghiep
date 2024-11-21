<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'order_detail_id'; 

    protected $fillable = [
        'order_id',
        'product_name',
        'product_quantity',
        'product_price',
    ];

    public $timestamps = false;
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_name', 'name');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}