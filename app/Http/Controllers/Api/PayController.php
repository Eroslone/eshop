<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Yansongda\LaravelPay\Facades\Pay;

class PayController extends Controller
{
    /**
     *微信支付
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'no' => 'required|string', // 订单号
        ]);

        $order = Order::where('no', '=', $request->no)
            ->first();
        if (!$order) {
            $data['message'] = "订单信息有误";
            return response()->json($data, 403);
        }

        if ($order->pay_status == 1) {
            $data['message'] = "订单已支付";
            return response()->json($data, 403);
        }

        if (!$request->openid) {
            $data['message'] = '用户信息有误';
            return response()->json($data, 200);
        }
        $openid = $request->openid;
        $config = config('pay.wechat');
        $order = [
            'out_trade_no' => $order->no,
            'description' => $order->no,
            'amount' => [
                'total' => (int)($order->price * 100),//$order->price
            ],
            'payer' => [
                'openid' => $openid,
            ],
        ];
        try {
            $response = Pay::wechat($config)->mp($order); // APP 支付
            $data = $response;
            return response()->json($data, 200);
        } catch (\Exception $e) {
            $data['message'] = '参数有误';
            $data['list'] = $e;
            return response()->json($data, 200);
        }

    }

    /**
     * 获取open_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getopenid(Request $request)
    {
        $code = implode($request->all('code'));
        $appid = 'wx9b3de038148b12d2';
        $appsecret = 'c4c3ebf4ac19d1f23fffd9a70b085404';
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appid . "&secret=" . $appsecret . "&code=" . $code . "&grant_type=authorization_code";
        //通过code换取网页授权access_token
        $weixin = file_get_contents($url);
        //对JSON格式的字符串进行编码
        $jsondecode = json_decode($weixin);
        //转换成数组
        $array = get_object_vars($jsondecode);
        //返回给小程序
        $data = $array;

        return response()->json($data, 200);;
    }

    /**
     * 微信回调
     * @param Request $request
     * @return string|void
     */
    public function wechatNotify(Request $request)
    {
        $config = config('pay.wechat');
        $pay = Pay::wechat($config);
        try {
            $data = $pay->callback(); // 是的，验签就这么简单！
            // 获取订单号  标记为已支付 TODO
            $out_trade_no = $data['resource']['ciphertext']['out_trade_no'];
            $trade_no = $data['resource']['ciphertext']['transaction_id'];

            $order = Order::where('no', '=', $out_trade_no)
                ->first();
            if ($order->pay_status != 1) {
                Order::where('no', '=', $out_trade_no)
                    ->update([
                        'paid_at' => date('Y-m-d H:i:s', time()),
                        'payment_method' => 'WeChat',
                        'pay_status' => 1,
                    ]);
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
        die('success');
    }
}
