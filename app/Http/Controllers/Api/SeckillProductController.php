<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderSons;
use App\Models\ProductAttr;
use App\Models\Products;
use App\Models\SeckillProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeckillProductController extends Controller
{

    /**
     * 秒杀列表
     * @param Request $request
     */
    public function seckillList(Request $request)
    {
        if (!empty($request->time)) {
            $time = $request->time;
        } else {
            $time = '';
        }
        $result = DB::table('seckill_products as sec')
            ->leftJoin('products', 'sec.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.categories_id', '=', 'categories.id')
            ->select('products.id', 'products.product_name', 'sec.price', 'categories.name as type', 'products.pictures', 'sec.amount')
            ->get()->toArray();
        foreach ($result as $value) {
            $value->picture_url = config('app.url') . "/storage/" . json_decode($value->pictures)[0];
        }
        $data['message'] = "秒杀商品列表";
        $data['list'] = $result;
        return response()->json($data, 200);
    }

    /**
     * 创建秒杀订单
     */
    public function seckillOrder(Request $request)
    {
        $request->validate([
            'address_id' => 'required',
            'price' => 'required',
        ]);
        $user = $request->user();
        $order = array(
            'no' => 'SC' . $this->findAvailableNo(),
            'user_id' => $user->id,
            'address_id' => $request->address_id,
            'type' => 2,
            'over_time' => date('Y-m-d H:i:s', time() + 600),
            'sign_time' => date('Y-m-d H:i:s', time() + 86400 * 7),
            'remark' => $request->remark,
            'price' => $request->price ?? '',
        );
        DB::beginTransaction();
//        try {
            $result = Order::create($order);
            if ($result) {
                $product = Products::where('id',$request->product_id)->first();
                $seckill = SeckillProduct::where('product_id', $product['id'])->first();
                if (empty($seckill)) {
                    $data['message'] = "该商品不支持秒杀";
                    return response()->json($data, 401);
                }
                if ($seckill->is_before_start) {
                    $data['message'] = "秒杀尚未开始";
                    return response()->json($data, 401);
                }
                if ($seckill->is_after_end) {
                    $data['message'] = "秒杀已经结束";
                    return response()->json($data, 401);
                }
                $price = $product['price'];
                $product_attr = ProductAttr::where('id', $request->model_id)->first();
                if ($product_attr['stock'] < $request->quantity) {
                    $data['message'] = $product['product_name'] . "库存不足";
                    return response()->json($data, 401);
                }
                OrderSons::create([
                    'order_id' => $result['id'],
                    'size_id' => $request->model_id,
                    'categories_id' => $product['categories_id'],
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'price' => $price,
                ]);
                DB::table('product_attrs')->where('id', $request->model_id)->decrement('stock', $request->quantity);
            }

//        } catch (\Exception $e) {
//            DB::rollback();
//            $data['message'] = "添加失败，检测提交参数";
//            $data['list'] = $e;
//            return response()->json($data, 401);
//        }
//        if ($order['price'] > 0) {
//            $orderInfo = [
//                'out_trade_no' => $order['no'],
//                'description' => $order['no'],
//                'amount' => [
//                    'total' => (int)($order['price'] * 100),//$order->price
//                ],
//                'payer' => [
//                    'openid' => $request->open_id,
//                ],
//            ];
//            $config = config('pay.wechat');
//            try {
//                $response = Pay::wechat($config)->mp($orderInfo); // APP 支付
//                DB::commit();
//                $this->dispatch(new CloseOrder($result, 600));
//                 $this->dispatch(new SignOrder($result, 86400*7));
//                $data = $response;
//                return response()->json($data, 200);
//            } catch (\Exception $e) {
//                DB::rollback();
//                $data['message'] = '参数有误';
//                $data['list'] = $e;
//                return response()->json($data, 400);
//            }
//        } else {
        DB::commit();
//            $this->dispatch(new CloseOrder($result, 30));
//            $this->dispatch(new SignOrder($result, 86400*7));
        $data['message'] = '添加成功';
        return response()->json($data, 200);
//        }
    }

    /**
     * 生成流水号
     *
     * @return bool|string
     * @throws \Exception
     */
    public static function findAvailableNo()
    {
        $prefix = date('YmdHis');
        $no = $prefix . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        return $no;
    }
}
