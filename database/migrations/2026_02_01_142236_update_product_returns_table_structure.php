<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('product_returns', function (Blueprint $table) {
            $table->dropColumn(['product_name', 'quantity', 'refund_amount']);
            $table->decimal('total_refund_amount', 15, 2)->default(0)->after('reason');
        });
    }

    public function down()
    {
        Schema::table('product_returns', function (Blueprint $table) {
            $table->string('product_name')->after('customer_id');
            $table->integer('quantity')->after('product_name');
            $table->decimal('refund_amount', 15, 2)->default(0)->after('reason');
            $table->dropColumn('total_refund_amount');
        });
    }
};
