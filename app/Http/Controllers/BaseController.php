<?php
namespace App\Http\Controllers;

class BaseController extends Controller
{
    /**
     * 成功消息提示
     *
     * @param $message
     * @param array $data
     * @param int $code
     * @param string $redirect
     * @param bool $isBase
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($message, $data = [], $code = 1001, $redirect = '', $isBase = true)
    {
        if ( ! $data ) $data = [];
        return $this->info(true, $message, $code, $redirect, $data);
    }

    /**
     * 错误消息提示
     *
     * @param $message
     * @param array $data
     * @param int $code
     * @param string $redirect
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($message, $data = [], $code = 1002, $redirect = '')
    {
        return $this->info(false, $message, $code, $redirect, $data);
    }

    /**
     * 消息提示
     *
     * @param $status
     * @param $message
     * @param $code
     * @param string $redirect
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function info($status, $message, $code, $redirect = '', $data = [])
    {
        $return = [
            'status'   => !!$status,
            'code'     => $code,
            'message'  => $message,
            'redirect' => $redirect,
            'data'     => $data
        ];
        return response()->json($return);
    }

    /**
     * 发送数据
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendData($data = [])
    {
        return $this->success('', $data);
    }

}