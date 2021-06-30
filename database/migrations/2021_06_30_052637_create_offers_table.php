<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['discount', 'bulk_order', 'buy_one_get_one', 'min_amount'])->default('discount');
            $table->integer('min_order')->default(1);
            $table->decimal('amount')->default(0);
            $table->enum('discount_type', ['fixed', 'percent'])->default('percent');
            $table->timestamp('offer_start')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('offer_end')->nullable();
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
        Schema::dropIfExists('offers');
    }
}
