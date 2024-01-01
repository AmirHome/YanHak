<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenefitCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('benefit_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('web_site')->nullable();
            $table->string('contact')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('phone')->nullable();
            $table->date('register_date')->nullable();
            $table->integer('tax_number')->nullable();
            $table->string('tax_office')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->timestamps();
        });
    }
}
