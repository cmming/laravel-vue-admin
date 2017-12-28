<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_blog')->create('post_topic_rel',function(Blueprint $table){
            $table ->increments('id');
            // varchar -> string    default 设置默认值
            $table->integer('post_id')->default(0);
            // 专题 id
            $table->integer('topic_id')->default(0);
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
        Schema::connection('mysql_blog')->dropIfExists('post_topic_rel');
    }
}
