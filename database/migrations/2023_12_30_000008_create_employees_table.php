<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('identity')->nullable();
            $table->date('birthday')->nullable();
            $table->string('mobile')->nullable();
            $table->string('name');
            $table->string('family');
            $table->string('gender')->nullable();
            $table->string('job_title')->nullable();
            $table->string('department')->nullable();
            $table->decimal('yearly_credit', 15, 2)->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }
}
