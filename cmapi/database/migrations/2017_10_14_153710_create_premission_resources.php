<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePremissionResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::connection('mysql')->create('premisison_resources',function(Blueprint $table){
			$table->increments('id');
			$table->integer('premission_id')->unique();
			$table->string('resources_id');
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
		Schema::connection('mysql')->dropIfExists('premisison_resources');
    }
}
