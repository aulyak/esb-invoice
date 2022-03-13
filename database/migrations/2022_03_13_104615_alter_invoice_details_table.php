<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInvoiceDetailsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('invoice_details', function (Blueprint $table) {
      $table->dropColumn('payments');
      $table->dropColumn('status');
      $table->decimal('amount', 22)->nullable()->default(0.00);
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