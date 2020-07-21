<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_item', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('item_id');
            $table->bigInteger('category_id')->unsigned(); 
            $table->foreign('category_id')->references('category_id')->on('tbl_category')->onDelete('cascade');
            $table->string('item_name');
            $table->text('item_description');
            $table->double('item_price',18,2);
            $table->tinyInteger('item_active')->default(1);
            $table->tinyInteger('item_archived')->default(0);
            $table->tinyInteger('is_out_of_stock')->default(0)->comment('[0 = false] [1 true]');
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
        Schema::dropIfExists('tbl_item');
    }
}
