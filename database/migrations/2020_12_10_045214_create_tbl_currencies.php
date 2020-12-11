<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblCurrencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('curr_id');
            $table->date('date');
            $table->text('name');
            $table->unsignedBigInteger('NumCode');
            $table->string('CharCode');
            $table->unsignedInteger('Nominal');
            $table->text('CurrName');
            $table->unsignedBigInteger('Value');
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
        Schema::dropIfExists('tbl_currencies');
    }
}
