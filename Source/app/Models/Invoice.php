<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'status',
        'total',
    ];

    // Định nghĩa mối quan hệ với khách hàng
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
