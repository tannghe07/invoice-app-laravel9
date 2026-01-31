<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_name',
        'quantity',
        'return_date',
        'reason',
        'refund_amount',
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
