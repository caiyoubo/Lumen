<?php
namespace App\Http\Controllers;

use App\Models\Details;
use Illuminate\Http\Request;

class TaoBaoController extends BaseController
{

    /**
     * 淘宝接口--商品信息
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_info()
    {
        $goods_id = $this->get_goods();
        $appKey     = 'xxxxx';  // 店铺的AppKey
        $appSecret  = 'xxxxx';  // 店铺的APPSecret
        $sessionkey = 'xxxxx';  // session
        //参数数组
        $paramArr = array(
            'app_key'     => $appKey,
            'fields'      => 'title, num_iid, pic_url, price, sku.sku_id',
            'format'      => 'json',
            'method'      => 'taobao.items.seller.list.get',    // 淘宝的官方api（如果是其它api，只要更换api即可）
            'session'     => $sessionkey,
            'sign_method' => 'md5',
            'timestamp'   => date('Y-m-d H:i:s'),
            'v'           => '2.0',
            'num_iids'    => $goods_id,
        );
        //签名
        $sign = $this->createSign($paramArr);
        //组织参数
        $strParam = $this->createStrParam($paramArr);
        $strParam .= 'sign='.$sign;
        //访问服务
        $url    =  'http://gw.api.tbsandbox.com/router/rest?'.$strParam;   // http://gw.api.taobao.com/router/rest （正式地址不要忘记？）
        $result = file_get_contents($url);
        $result = json_decode($result);

        return $this->success('成功！', $result);
    }

    public function get_goods()
    {
        $info = Details::select('*')
            ->orderByRaw('RAND()')
            ->take(18)
            ->get()->toArray(); // 随机从数据库中取出18条数据。
        $r = $info[0]['goods_id'].",".$info[1]['goods_id'].",".$info[2]['goods_id'].",".$info[3]['goods_id'].",".$info[4]['goods_id'].",".
        $info[5]['goods_id'].",".$info[6]['goods_id'].",".$info[7]['goods_id'].",".$info[8]['goods_id'].",".$info[9]['goods_id'].",".$info[10]['goods_id']
        .",".$info[11]['goods_id'].",".$info[12]['goods_id'].",".$info[13]['goods_id'].",".$info[14]['goods_id'].",".$info[15]['goods_id'].
        ",".$info[16]['goods_id'].",".$info[17]['goods_id'];

        return $r;

    }

    //签名函数
    function createSign ($paramArr) {
        $appSecret = 'xxxxxx';
        ksort($paramArr);
        $sign = $appSecret;
        foreach( $paramArr as $k => $v ) {
            if ( "@" != substr($v, 0, 1) ) {
                $sign .= "$k$v";
            }
        }
        unset($k, $v);
        $sign .= $appSecret;
        return strtoupper(md5($sign));
    }

    //组参函数
    function createStrParam ($paramArr) {
        $strParam = '';
        foreach ($paramArr as $key => $val) {
            if ($key != '' && $val != '') {
                $strParam .= "$key=".urlencode($val).'&';
            }
        }

        return $strParam;
    }
}