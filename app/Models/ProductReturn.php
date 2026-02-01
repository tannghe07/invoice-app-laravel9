<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'return_date',
        'reason',
        'total_refund_amount',
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }

    public function details()
    {
        return $this->hasMany(ProductReturnDetail::class);
    }
}
