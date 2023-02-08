<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigInteger('customer_id')->unsigned();
            $table->dateTime('created_on', $precision = 4);
            $table->bigInteger('workagent_id')->unsigned();
            $table->string('total');
            $table->string('status')->default('active');
            $table->string('paid')->default(0);
            $table->string('balance')->default(0);
            $table->string('process')->default(0);
            $table->foreign('customer_id')
                ->references('id')->on('customers')
            $table->foreign('workagent_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('invoices');
    }
}
