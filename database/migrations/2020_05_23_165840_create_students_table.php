<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateStudentsTable.
 */
class CreateStudentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('students', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lecturer_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('class')->nullable();
            $table->foreign('lecturer_id')->references('id')->on('lecturers');
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
		Schema::drop('students');
	}
}
