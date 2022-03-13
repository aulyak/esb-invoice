<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubItemsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('sub_items', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->timestamps();
      $table->string('description', 255)->nullable();
      $table->decimal('unit_price', 22)->nullable()->default(0.00);
      $table->unsignedBigInteger('item_id');
    });

    Schema::table('sub_items', function (Blueprint $table) {
      $table->foreign('item_id')->references('id')->on('items');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('sub_items');
  }
}