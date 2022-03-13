<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDetailsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('invoice_details', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->timestamps();
      $table->bigInteger('quantity');
      $table->decimal('payments', 22)->nullable()->default(0.00);
      $table->unsignedBigInteger('invoice_id');
      $table->unsignedBigInteger('sub_item_id');
    });

    Schema::table('invoice_details', function (Blueprint $table) {
      $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
      $table->foreign('sub_item_id')->references('id')->on('sub_items')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('invoice_details');
  }
}