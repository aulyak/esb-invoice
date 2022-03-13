<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableInvoiceDetailsAddOnCascade extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('invoice_details', function (Blueprint $table) {
      $table->dropForeign('invoice_details_sub_item_id_foreign');
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
    Schema::table('invoice_details', function (Blueprint $table) {
      //
    });
  }
}