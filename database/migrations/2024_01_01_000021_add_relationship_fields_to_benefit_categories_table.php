<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBenefitCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('benefit_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_9353012')->references('id')->on('teams');
        });
    }
}
