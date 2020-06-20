<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateCompartmentsTable.
 */
class CreateCompartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compartments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('laboratory_id');
            $table->string('name');
            $table->integer('tables');
            $table->integer('chairs');
            $table->integer('computers');
            $table->foreign('laboratory_id')->references('id')->on('laboratories');
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
        Schema::drop('compartments');
    }
}
