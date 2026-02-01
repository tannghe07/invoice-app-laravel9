<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product_return_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_return_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name');
            $table->integer('quantity');
            $table->decimal('refund_price', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('product_return_id')->references('id')->on('product_returns')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_return_details');
    }
};
