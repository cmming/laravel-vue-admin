<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
	 * 统一处理 模型的各种数据
	 *
	 * 1.黑名单 $guarded save 或 update 方法 不能对数据库中的字段进行 赋值
	 * 2.      $fillable  支持批量复制 （与上面的相反） 不设置表示为全部可以该
	 * 3.      $hidden  转换成数组或 JSON 时，自动隐藏属性 例如密码
	 */

	protected $fillable = ['author_id','file_name','file_size','file_type','file_url',
		'tid','title','fname','des','att','down_url','fsize','ftype','authorid','author',
		'uid','mid'
	];
	protected $hidden = ['ad_pwd'];

}
