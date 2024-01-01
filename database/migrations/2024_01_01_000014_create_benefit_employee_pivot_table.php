<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenefitEmployeePivotTable extends Migration
{
    public function up()
    {
        Schema::create('benefit_employee', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id', 'employee_id_fk_9346837')->references('id')->on('employees')->onDelete('cascade');
            $table->unsignedBigInteger('benefit_id');
            $table->foreign('benefit_id', 'benefit_id_fk_9346837')->references('id')->on('benefits')->onDelete('cascade');
        });
    }
}
