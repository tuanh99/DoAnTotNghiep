<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
       'user_id', 'customer_id', 'customer_name', 'phone', 'address', 'email', 'content', 'total_amount', 'status'
    ];
    public $timestamps = false;
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class,'order_id', 'id');
    }
}