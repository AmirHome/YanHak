<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBenefitPackagesTable extends Migration
{
    public function up()
    {
        Schema::table('benefit_packages', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_9353134')->references('id')->on('teams');
        });
    }
}
