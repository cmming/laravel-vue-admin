<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserWxInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_air')->create('user_wx_info',function(Blueprint $table){
            $table ->increments('id');
            // varchar -> string    default 设置默认值
            $table->string('openid')->default('');
            $table->string('nickname')->default('');
            $table->string('headimgurl')->default('');

            $table->integer('user_id')->default(0);

            $table->unique('openid','user_id');
            // 时间戳
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
        Schema::connection('mysql_air')->dropIfExists('user_wx_info');
    }
}
