<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'content',
        'status'
    ];
    protected $attributes = [
        'status' => 'Đang chuẩn bị', 
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class, 'customer_id', 'id');
    }
    public function invoices()
{
    return $this->hasMany(Invoice::class);
}

}
