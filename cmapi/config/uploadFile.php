<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15
 * Time: 14:14
 */


//生成文件的上传的配置文件
return [
	'USER_ORI_FILE_CACHE_TIME'=>env('USER_ORI_FILE_CACHE_TIME','259200'),
	'USER_ORI_FILE_CACHE_URL'=>env('USER_ORI_FILE_CACHE_URL',''),
	'USER_ORI_FILE_SERVICE_DEFAULT_PATH'=>env('USER_ORI_FILE_SERVICE_DEFAULT_PATH',''),
	'APP_ENV'=>env('APP_ENV','local'),
];