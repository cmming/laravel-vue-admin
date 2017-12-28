<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_blog')->create('comments',function(Blueprint $table){
            $table->increments('id');
            $table->string('content');
            $table->integer('post_id');
            //发表的用户
            $table->integer('user_id');
            //关联的 上级 留言的编号 可以为null
            $table->integer('p_comments_id')->nullable();
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
        Schema::connection('mysql_blog')->dropIfExists('comments');
    }
}
