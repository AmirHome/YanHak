<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenefitPackagesTable extends Migration
{
    public function up()
    {
        Schema::create('benefit_packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->decimal('credit_amount', 15, 2)->nullable();
            $table->timestamps();
        });
    }
}
