<?php

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueryListener
{
    /**
     * Create the event listener.
     * 事件 监视器
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *处理 事件
     * @param  QueryExecuted  $event
     * @return void
     */
    public function handle(QueryExecuted $event)
    {
        //
		$sql = str_replace("?", "'%s'", $event->sql);

		$log = vsprintf($sql, $event->bindings);

		$connectionName = $event->connectionName;

//        $log = '[' . date('Y-m-d H:i:s') . ',数据库名称：'.$connectionName.'] ' . $log . "\r\n";
//        $filepath = storage_path('logs\sql.log');
//        file_put_contents($filepath, $log, FILE_APPEND);
		$log = '数据库名称：'.$connectionName.',sql='.$log;
		\Log::info($log);

		// 这里也可以直接用Log::info() 里的函数，只是这样会和其他调试信息掺在一起。
		// 如果要用Log里的函数，别忘记了引入Log类。
    }
}
