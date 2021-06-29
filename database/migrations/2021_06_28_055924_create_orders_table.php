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
            $table->uuid('invoice_id')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total_payable', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->enum('status', ['pending', 'active', 'processing', 'cancelled', 'complete'])->default('pending')->index('order_status');
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
