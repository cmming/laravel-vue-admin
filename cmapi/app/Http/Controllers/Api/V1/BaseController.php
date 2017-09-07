<?php

namespace App\Http\Controllers\Api\V1;

// 
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Dingo\Api\Exception\ValidationHttpException;

class BaseController extends Controller
{
    // 接口帮助调用
    // dingo api响应数据的封装
    // https://github.com/liyu001989/dingo-api-wiki-zh/blob/master/Responses.md

    // 响应一个数组
    // return $this->response->array($user->toArray());
    // 响应一个元素
    // return $this->response->item($user, new UserTransformer);
    // 响应一个元素集合
    // return $this->response->collection($users, new UserTransformer);
    // 分页响应
    // return $this->response->paginator($users, new UserTransformer);
    //  无内容响应
    // return $this->response->noContent();
    // 创建了资源的响应
    // return $this->response->created();



    // 这有很多不同的方式创建错误响应，你可以快速的生成一个错误响应。
    // // A generic error with custom message and status code.
    // // 一个自定义消息和状态码的普通错误。
    // return $this->response->error('This is an error.', 404);

    // // A not found error with an optional message as the first parameter.
    // // 一个没有找到资源的错误，第一个参数可以传递自定义消息。
    // return $this->response->errorNotFound();

    // // A bad request error with an optional message as the first parameter.
    // // 一个 bad request 错误，第一个参数可以传递自定义消息。
    // return $this->response->errorBadRequest();

    // // A forbidden error with an optional message as the first parameter.
    // // 一个服务器拒绝错误，第一个参数可以传递自定义消息。
    // return $this->response->errorForbidden();

    // // An internal error with an optional message as the first parameter.
    // // 一个内部错误，第一个参数可以传递自定义消息。
    // return $this->response->errorInternal();

    // // An unauthorized error with an optional message as the first parameter.
    // // 一个未认证错误，第一个参数可以传递自定义消息。
    // return $this->response->errorUnauthorized();


    // 添加额外的头信息
    // withHeader('X-Foo', 'Bar');

    use Helpers;

    // 返回错误的请求
    protected function errorBadRequest($validator)
    {
        // github like error messages
        // if you don't like this you can use code bellow
        //
        //throw new ValidationHttpException($validator->errors());

        $result = [];
        $messages = $validator->errors()->toArray();

        if ($messages) {
            foreach ($messages as $field => $errors) {
                foreach ($errors as $error) {
                    $result[] = [
                        'field' => $field,
                        'code' => $error,
                    ];
                }
            }
        }

        throw new ValidationHttpException($result);
    }
}
