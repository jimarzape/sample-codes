<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblItemImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_item_image', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('item_image_id');
            $table->bigInteger('item_id')->unsigned();
            $table->foreign('item_id')->references('item_id')->on('tbl_item')->onDelete('cascade');
            $table->string('item_image');
            $table->tinyInteger('item_image_main')->default(0)->comment('[0 = sub] [1 = main]');
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
        Schema::dropIfExists('tbl_item_image');
    }
}
