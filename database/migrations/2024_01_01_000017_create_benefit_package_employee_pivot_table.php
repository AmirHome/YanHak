<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenefitPackageEmployeePivotTable extends Migration
{
    public function up()
    {
        Schema::create('benefit_package_employee', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id', 'employee_id_fk_9354469')->references('id')->on('employees')->onDelete('cascade');
            $table->unsignedBigInteger('benefit_package_id');
            $table->foreign('benefit_package_id', 'benefit_package_id_fk_9354469')->references('id')->on('benefit_packages')->onDelete('cascade');
        });
    }
}
