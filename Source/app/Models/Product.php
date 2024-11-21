<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'content',
        'menu_id',
        'price_cost',
        'price',
        'price_sale',
        'stock',
        'active',
        'thumb'
    ];

    public function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'menu_id')
            ->withDefault(['name' => '']);
        // return $this->belongsTo(Menu::class);
        
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_name', 'name');
    }
    public function getUpdatedAtFormatAttribute()
    {
        return $this->updated_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s');
    }
    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }
}
