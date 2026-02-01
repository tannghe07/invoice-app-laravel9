<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReturnDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_return_id',
        'product_id',
        'product_name',
        'quantity',
        'refund_price'
    ];

    public function productReturn()
    {
        return $this->belongsTo(ProductReturn::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
