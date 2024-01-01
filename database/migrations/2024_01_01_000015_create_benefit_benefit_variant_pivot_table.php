<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenefitBenefitVariantPivotTable extends Migration
{
    public function up()
    {
        Schema::create('benefit_benefit_variant', function (Blueprint $table) {
            $table->unsignedBigInteger('benefit_id');
            $table->foreign('benefit_id', 'benefit_id_fk_9353038')->references('id')->on('benefits')->onDelete('cascade');
            $table->unsignedBigInteger('benefit_variant_id');
            $table->foreign('benefit_variant_id', 'benefit_variant_id_fk_9353038')->references('id')->on('benefit_variants')->onDelete('cascade');
        });
    }
}
