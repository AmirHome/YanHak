<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenefitPackageBenefitVariantPivotTable extends Migration
{
    public function up()
    {
        Schema::create('benefit_package_benefit_variant', function (Blueprint $table) {
            $table->unsignedBigInteger('benefit_package_id');
            $table->foreign('benefit_package_id', 'benefit_package_id_fk_9353130')->references('id')->on('benefit_packages')->onDelete('cascade');
            $table->unsignedBigInteger('benefit_variant_id');
            $table->foreign('benefit_variant_id', 'benefit_variant_id_fk_9353130')->references('id')->on('benefit_variants')->onDelete('cascade');
        });
    }
}
