<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenefitVariantEmployeePivotTable extends Migration
{
    public function up()
    {
        Schema::create('benefit_variant_employee', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id', 'employee_id_fk_9353057')->references('id')->on('employees')->onDelete('cascade');
            $table->unsignedBigInteger('benefit_variant_id');
            $table->foreign('benefit_variant_id', 'benefit_variant_id_fk_9353057')->references('id')->on('benefit_variants')->onDelete('cascade');
        });
    }
}
