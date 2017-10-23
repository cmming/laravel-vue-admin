<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePremissionRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
//	protected $connection = 'mysql_vr';

    public function up()
    {
        //用户权限表
		Schema::connection('mysql')->create('user_premissions',function(Blueprint $table){
//		Schema::create('user_premissions',function(Blueprint $table){
			$table->increments('id');
			$table->string('name','30')->unique();
			$table->string('desc','100')->default('');
			$table->timestamps();
		});
		//用户角色表
		Schema::connection('mysql')->create('user_roles',function(Blueprint $table){
//		Schema::create('user_roles',function(Blueprint $table){
			$table->increments('id');
			$table->string('name','30')->unique();
			$table->string('desc','100')->default('');
			$table->timestamps();
		});
		//用户的权限与角色表的关系表
		Schema::connection('mysql')->create('user_premission_role',function(Blueprint $table){
//		Schema::create('user_premission_role',function(Blueprint $table){
			$table->increments('id');
			$table->integer('role_id');
			$table->integer('premission_id');
			$table->unique(['role_id', 'premission_id']);
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
//		Schema::dropIfExists('user_premissions');
		Schema::connection('mysql')->dropIfExists('user_premissions');
//		Schema::dropIfExists('user_roles');
		Schema::connection('mysql')->dropIfExists('user_roles');
//		Schema::dropIfExists('user_premission_role');
		Schema::connection('mysql')->dropIfExists('user_premission_role');
	}
}
