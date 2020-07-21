<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblMenuSearch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_menusearch', function (Blueprint $table) {
            $table->bigIncrements('menusearch_id');
            $table->engine = 'MyISAM';
            $table->integer('item_id');
            $table->text('menu_body');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE tbl_menusearch ADD FULLTEXT search(menu_body)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_menusearch');
    }
}
