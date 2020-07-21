<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblItemTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_item_tags', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('item_tags_id');
            $table->bigInteger('item_id')->unsigned();
            $table->foreign('item_id')->references('item_id')->on('tbl_item')->onDelete('cascade');
            $table->bigInteger('ingredient_id')->unsigned()->nullable();
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
        Schema::dropIfExists('tbl_item_tags');
    }
}
