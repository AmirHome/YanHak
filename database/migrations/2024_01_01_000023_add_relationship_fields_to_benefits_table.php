<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBenefitsTable extends Migration
{
    public function up()
    {
        Schema::table('benefits', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id', 'category_fk_9353037')->references('id')->on('benefit_categories');
            $table->unsignedBigInteger('benefit_company_id')->nullable();
            $table->foreign('benefit_company_id', 'benefit_company_fk_9353156')->references('id')->on('benefit_companies');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_9353036')->references('id')->on('teams');
        });
    }
}
