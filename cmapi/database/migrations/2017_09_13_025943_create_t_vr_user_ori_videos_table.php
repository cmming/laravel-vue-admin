<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTVrUserOriVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('t_vr_user_ori_resources',function(Blueprint $table){
			$table->increments('id');
			$table->integer('user_id');
			$table->string('file_name',128)->default('');
			$table->integer('file_size')->default(0);
			$table->string('file_type',8)->default('');
			$table->text('file_url');
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
		Schema::dropIfExists('t_vr_user_ori_resources');
    }
}
