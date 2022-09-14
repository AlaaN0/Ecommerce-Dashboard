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
            $table->char('Name', 16);
            $table->text('Description');
            $table->decimal('Cost_Price');
            $table->decimal('Price');
            $table->decimal('Sale_Price');
            $table->string('SKU');
            $table->integer('Quantity');
            $table->string('Featured_Image');
            $table->string('Images')->nullable();

            $table->unsignedBigInteger('Category_id')->nullable();
            $table->foreign('Category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('SET NULL')->onUpdate('cascade');
            
            $table->unsignedBigInteger('Brand_id')->nullable();
            $table->foreign('Brand_id')
                  ->references('id')
                  ->on('brands')
                  ->onDelete('SET NULL')->onUpdate('cascade');
            $table->string('Status')->default('Active');
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
