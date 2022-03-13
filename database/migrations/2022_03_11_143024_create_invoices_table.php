<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('invoices', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->timestamps();
      $table->dateTime('due_date', $precision = 0);
      $table->string('subject', 255)->nullable();
      $table->decimal('subtotal', 22)->nullable()->default(0.00);
      $table->decimal('tax', 22)->nullable()->default(0.00);
      $table->decimal('payments', 22)->nullable()->default(0.00);
      $table->enum('status', ['paid', 'unpaid']);
      $table->unsignedBigInteger('customer_id');
    });

    Schema::table('invoices', function (Blueprint $table) {
      $table->foreign('customer_id')->references('id')->on('customers');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('invoices');
  }
}