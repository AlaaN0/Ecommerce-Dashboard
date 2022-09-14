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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->char('Name', 16);
            $table->text('Description')->nullable();
            $table->string('Image')->nullable();
            $table->unsignedBigInteger('Parent_id')->nullable();
            $table->foreign('Parent_id')
                  ->references('id')
                  ->on('categories')
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
        Schema::dropIfExists('categories');
    }
};
