<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('services', function (Blueprint $table) {
      $table->increments('id');
      $table->string('shortened')->unique();
      $table->string('name')->nullable();
      $table->string('href')->unique();
      $table->string('href_manual')->nullable();
      $table->integer('icon_id')->unsigned();
      $table->foreign('icon_id')->references('id')->on('icons');
      $table->integer('group_id')->unsigned();
      $table->foreign('group_id')->references('id')->on('groups');
      $table->text('description')->nullable();
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
    Schema::dropIfExists('services');
  }
}
