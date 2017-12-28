<?php
/**
 * Created by PhpStorm.
 * topic: Administrator
 * Date: 2017/11/11
 * Time: 17:42
 */

namespace App\Http\Controllers\Api\V1\Blog;

use App\Models\Blog\Topic;
use App\Transformers\TopicTransformer;

class TopicController extends BaseController
{
    protected $topic;

    public function __construct(Topic $topic)
    {
        $this->topic = $topic;
    }

    public function index()
    {

        $sear_arr = $this->noMustHas(
            array(
                array('isExcel' => 'string'),
                array('limit' => 'numeric'),
                array('btime' => 'date_format:Y-m-d'),
                array('etime' => 'date_format:Y-m-d'),
            )
        );
        //处理 搜索 参数
        $limit = isset($sear_arr['limit']) ? $sear_arr['limit'] : 15;
        $btime = isset($sear_arr['btime']) ? $sear_arr['btime'] : '';
        $etime = isset($sear_arr['etime']) ? $sear_arr['etime'] : '';
//        $name = isset($sear_arr['name']) ? $sear_arr['name'] : '';
        $name = request('name');
        $isExcel = isset($sear_arr['isExcel']) ? $sear_arr['isExcel'] : 'false';

        $topics = $this->topic->where(function ($query) use ($btime, $etime, $name) {
            if ($etime != '') {
                $query->where('created_at', '>=', $btime . (' 00:00:00'))->where('created_at', '<=', $etime . (' 23:59:59'));
            } else {
                $query->where('created_at', '>=', $btime . (' 00:00:00'));
            }
            if ($name) {
                $query->where('name', 'like', '%'. $name . '%');
            }
        });
        if ($isExcel != 'false') {
            return $this->response->array(['data' => $topics->get()->toArray()]);
        } else {
            $topics = $topics->paginate($limit);
        }
//		$topics = $this->topic->paginate();

        return $this->response->paginator($topics, new TopicTransformer());
    }

    //
    public function store()
    {
        $validator = \Validator::make(request()->all(), [
            'name' => 'required|string:2:10'
        ]);
        //
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $premission = $this->topic->create(request(['name']));

        return $this->response->created();
    }

    //

    public function update($id)
    {
        $topic = $this->topic->findOrFail($id);
        $validator = \Validator::make(request(['name']), [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $topic->update(request(['name']));
        return $this->response->noContent();
    }

    public function show($id)
    {
        $validator = \Validator::make(['id' => $id], [
            'id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        //findOrFail 根据主键取出一条数据或抛出异常
        $isExist = $this->topic->find($id);

        if ($isExist) {
            // item 是返回单个数据
            return $this->response->item($isExist, new TopicTransformer());
        } else {
            $result = array();
            $result['code'] = 201;
            $result['msg'] = '该资源不存在';
            return $this->response->array($result);
        }
    }

    public function destroy($id)
    {
        $validator = \Validator::make(['id' => $id], [
            'id' => 'numeric|unique:mysql_blog.topics,id',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $userOriFile = $this->topic->find($id);

        $isExists = $this->topic->where('id', '=', $id)->exists();
        if ($isExists) {
            $this->topic->destroy($id);
        }

        return $this->response->noContent();

    }


}