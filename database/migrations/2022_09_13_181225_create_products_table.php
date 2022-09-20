<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->integer('cost_price');
            $table->integer('price')->check ('price' > 'cost_price');
            $table->integer('sale_price')->check(('sale_price' < 'price') AND ('sale_price' > 'cost_price'));
            $table->string('sku');
            $table->integer('quantity');
            $table->string('featured_image');
            $table->string('images')->nullable();
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->foreignId('brand_id')->references('id')->on('brands');
            $table->string('status')->default('Active');
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
        Schema::dropIfExists('products');
    }
};
