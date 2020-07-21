<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPermissionLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_permission_link', function (Blueprint $table) {
            $table->bigIncrements('permission_link_id');
            $table->unsignedBigInteger('permission_id')->nullable();
            $table->foreign('permission_id')->references('permission_id')->on('tbl_permissions')->onDelete('cascade');
            $table->string('link_desc');
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
        Schema::dropIfExists('tbl_permission_link');
    }
}
