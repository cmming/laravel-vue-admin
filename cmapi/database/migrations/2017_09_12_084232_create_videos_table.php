<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建 videos 表
		Schema::create('videos',function(Blueprint $table){
			$table->increments('id');
			$table->integer('user_id');
			$table->string('name','50');
			$table->string('url','200')->default('');
			$table->integer('is_free')->default('1');
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
		Schema::dropIfExists('videos');
    }
}
