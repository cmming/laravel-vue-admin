<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 路由表
		Schema::connection('mysql')->create('routers',function(Blueprint $table){
			$table->increments('id');
			$table->string('title','100')->default('');
			$table->string('path');
			$table->string('componentPath');
			$table->string('type');
			$table->string('iconFont')->default('');
			$table->integer('sort')->default(0);
//			$table->unique('path');//唯一 索引
			$table->timestamps();
		});
		//路由关系表
		Schema::connection('mysql')->create('routers_rel',function(Blueprint $table){
			$table->increments('id');
			$table->integer('parent_id');
			$table->integer('son_id');
			$table->unique('son_id');//唯一 索引 一个路由只能被一个路由作为子路由
			$table->timestamps();
		});
		//路由权限关系表
		Schema::connection('mysql')->create('router_premission_rel',function(Blueprint $table){
			$table->increments('id');
			$table->integer('router_id');
			$table->integer('premission_id');
			$table->unique('router_id','premisison_id');//唯一 索引
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
		Schema::connection('mysql')->dropIfExists('router');
		Schema::connection('mysql')->dropIfExists('routers_rel');
		Schema::connection('mysql')->dropIfExists('router_premission_rel');
    }
}
