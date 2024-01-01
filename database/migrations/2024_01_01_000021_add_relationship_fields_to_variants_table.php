<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVariantsTable extends Migration
{
    public function up()
    {
        Schema::table('variants', function (Blueprint $table) {
            $table->unsignedBigInteger('benefit_id')->nullable();
            $table->foreign('benefit_id', 'benefit_fk_9353461')->references('id')->on('benefits');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_9353465')->references('id')->on('teams');
        });
    }
}
