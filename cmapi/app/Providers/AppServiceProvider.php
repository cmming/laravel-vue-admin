<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //函数启动之后会执行  设置string 的默认长度 为191
        Schema::defaultStringLength(191);
        //向 所有的view 添加 topic
        \View::composer('blog.layout.main',function($view){
            $topics = \App\Models\Blog\Topic::all();
            $view->with('topics',$topics);
        });

        \Carbon\Carbon::setLocale('zh');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
