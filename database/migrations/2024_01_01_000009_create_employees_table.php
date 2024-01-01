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
            $table->string('name');
            $table->string('sur_name');
            $table->string('personel')->nullable();
            $table->string('identity_number')->nullable();
            $table->string('working_type')->nullable();
            $table->string('job_title')->nullable();
            $table->string('department')->nullable();
            $table->decimal('yearly_credit', 15, 2)->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }
}
