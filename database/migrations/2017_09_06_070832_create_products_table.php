<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->text('optional');
            $table->text('images');
            $table->integer('price');
            $table->boolean('is_discount')->default(0);
            $table->integer('discount');
            $table->integer('category_id');
            $table->integer('brand_id');
            $table->boolean('is_homepage')->default(0);
            $table->integer('user_id')->unsigned();
            $table->boolean('active')->default(0);
            $table->integer('stock');
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
}
