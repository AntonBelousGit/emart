<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('order_number',20)->unique();
            $table->float('sub_total')->default(0);
            $table->float('total_amount')->default(0);
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->float('coupon')->default(0)->nullable();
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->float('delivery_charge')->default(0)->nullable();
            $table->string('payment_method')->default('cod'); //cash on delivery
            $table->enum('payment_status',['paid','unpaid'])->default('unpaid');
            $table->enum('condition',['pending','processing','delivered','cancelled','back'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
