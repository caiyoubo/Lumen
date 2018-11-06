<?php
namespace App\Http\Controllers\Login;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;


class LoginController extends BaseController
{
    public function index(Request $request)
    {
        $age = $request->input('age');
        if ( ! $age )
        {
            return $this->error('参数错误！');
        }

        return $this->success('这个年龄是正确的。');
    }
}