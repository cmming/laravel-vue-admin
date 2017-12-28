<?php
/**
 * Created by PhpStorm.
 * post: Administrator
 * Date: 2017/11/11
 * Time: 17:42
 */

namespace App\Http\Controllers\Api\V1\Blog;

use App\Models\Blog\Post;
use App\Transformers\Blog\PostTransformer;

class PostController extends BaseController
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
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
        $name = request('title');
        $isExcel = isset($sear_arr['isExcel']) ? $sear_arr['isExcel'] : 'false';

        $posts = $this->post->where(function ($query) use ($btime, $etime, $name) {
            if ($etime != '') {
                $query->where('created_at', '>=', $btime . (' 00:00:00'))->where('created_at', '<=', $etime . (' 23:59:59'));
            } else {
                $query->where('created_at', '>=', $btime . (' 00:00:00'));
            }
            if ($name) {
                $query->where('title', 'like','%'. $name . '%');
            }
        });
        if ($isExcel != 'false') {
            return $this->response->array(['data' => $posts->get()->toArray()]);
        } else {
            $posts = $posts->paginate($limit);
        }
//		$posts = $this->post->paginate();

        return $this->response->paginator($posts, new PostTransformer());
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
        $premission = $this->post->create(request(['name']));

        return $this->response->created();
    }

    //

    public function update($id)
    {
        $post = $this->post->findOrFail($id);
        $validator = \Validator::make(request(['name']), [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $post->update(request(['name']));
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
        $isExist = $this->post->find($id);

        if ($isExist) {
            // item 是返回单个数据
            return $this->response->item($isExist, new PostTransformer());
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
            'id' => 'numeric|unique:mysql_blog.posts,id',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $userOriFile = $this->post->find($id);

        $isExists = $this->post->where('id', '=', $id)->exists();
        if ($isExists) {
            $this->post->destroy($id);
        }

        return $this->response->noContent();

    }


}