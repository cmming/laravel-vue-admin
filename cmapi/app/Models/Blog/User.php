<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/10
 * Time: 16:42
 */

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

//class User extends BaseModel
class User extends Authenticatable
{
    use Notifiable;
    //设置数据库连接
    protected $connection = 'mysql_blog';
    //设置 关联表

    protected $table = 'users';
    //白名单

    protected $fillable = ['name','password','email'];

    public function posts(){
        return $this->hasMany('\App\Models\Blog\Post','user_id','id');
    }


}