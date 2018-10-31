<?php
namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class MakeController extends BaseController
{
    /**
     * Excel表导出
     */
    public function export()
    {
        $data = Goods::select('uid', 'goods_id',
                DB::raw("case state
                when 0 then '否'
                when 1 then '是'
                else '否' end
                "),
                DB::raw("case voucher
                when 1 then '3000元清空大奖'
                when 2 then '85元购物津贴'
                when 3 then '65元优惠券'
                when 4 then '55元优惠劵'
                else '未知' end
                "),
            'tb_id','tel', 'time')->where('state', 1)->orderBy('time')->get()->toArray();
        $ids = ['用户ID', '商品ID', '是否中奖', '优惠券', '淘宝ID', '领奖手机号', '加购时间'];
        array_unshift($data, $ids);
        Excel::create(iconv('UTF-8', 'GBK', '清空购物车大奖表'), function($excel) use ($data){
            $excel->sheet('goods', function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export('xls');
    }

    /**
     * 抽奖程序
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
   public function get_rand(Request $request)
   {
//       if ( (date('Y-m-d', time()) < date('Y-m-d', '1541001600')) || (date('Y-m-d', time()) > date('Y-m-d', '1541851200')) )
//       {
//           return $this->error('对不起！活动已结束，感谢您的参与！');
//       }//活动时间，上线的时候开启。
       $data = [];
       $uid = $request->input('uid');
       if ( ! $uid )
       {
           return $this->error('参数错误！');
       }
       $luck = Goods::where('uid', $uid)->where('state', 1)->count();
       if ( $luck > 0 )
       {
           $data[] = 4;
       }
       $ids = Goods::where('uid', $uid)->where('voucher', '!=', 0)->count();
       if ( $ids == 0 )
       {
           $data[] = 4;
       }
       elseif ( $ids == 1 )
       {
           $data[] = 3;
       }
       elseif ( $ids == 2 )
       {
           $data[] = 2;
       }
       else
       {
           $query = Goods::where('state', 1)
               ->whereDate('time', date('Y-m-d', time()))
               ->exists();//检索当天有没有中3000元大奖的玩家
           if ( $query )
           {
               $total1 = 0;
               $total2 = 20;
               $total3 = 30;
               $total4 = 50;
           }
           else
           {
               $total1 = 10;
               $total2 = 20;
               $total3 = 30;
               $total4 = 40;
           }
           $win1   = $total1;
           $win2   = $total2;
           $win3   = $total3;
           $other  = $total4;

           for ($i = 0; $i < $win1; $i++)
           {
               $data[] = 1;
           }
           for ($j = 0; $j < $win2; $j++)
           {
               $data[] = 2;
           }
           for ($k = 0; $k < $win3; $k++)
           {
               $data[] = 3;
           }
           for ($n = 0; $n < $other; $n++)
           {
               $data[] = 4;
           }
       }

       shuffle($data);
       $rt = $data[array_rand($data)];
       if ( $rt == 1 )
       {
           $state = 1;
       }
       else
       {
           $state = 0;
       }
       $arr = [
         'uid'     => $uid,
         'voucher' => $rt,
         'state'   => $state,
       ];
       Goods::create($arr);
       return $this->success('', $rt);
   }

    /**
     * 调用第三方接口（curl方式）
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_vip(Request $request)
    {
        $uid = $request->input('uid');
        if ( ! $uid )
        {
            return $this->error('参数有误!');
        }
        $uid = $request->input('uid');
        $response = Curl::to('xxxxxxxx')    //  要调用的api
            ->withData(array(  //  调用api所需要的请求参数
                'mixNick'  => $uid,
                'sellerId' => '94399436',
                'deviceId' => 'BBBA3EAAC1',
            ))
            ->asJson()->post(); //  被调用的api的传参方式get or post

        return $this->success('调用成功。', $response);
    }

    public function test()
    {
        //
    }

}