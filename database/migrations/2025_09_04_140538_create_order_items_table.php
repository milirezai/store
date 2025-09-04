<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('product_object')->nullable();
            $table->foreignId('amazing_sale_id')->nullable()->constrained('amazing_sales')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('amazing_sale_object')->nullable();
            $table->decimal('amazing_sale_discount_amount',20,3)->nullable();
            $table->integer('number')->default(1);
            $table->decimal('final_product_amount',20,3)->nullable();
            $table->decimal('final_total_price',20,3)->nullable()->comment('price * final_product_amount');
            $table->foreignId('color_id')->nullable()->constrained('product_colors')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('guarantee_id')->nullable()->constrained('guarantees')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
