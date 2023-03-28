<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SalesCommissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('sales_commissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('workagent_id')->unsigned();
            $table->bigInteger('invoice_id')->unsigned();
            $table->float('commission');
            $table->dateTime('created_on', $precision = 4);
            $table->foreign('workagent_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('invoice_id')
                ->references('id')->on('invoices')
                ->onDelete('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('sales_commissions');
    }
}
