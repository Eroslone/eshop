<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\CloseOrder;
use App\Jobs\SignOrder;
use App\Models\Address;
use App\Models\Exchange_goods;
use App\Models\Order;
use App\Models\OrderSons;
use App\Models\Product;
use App\Models\Product_attr;
use App\Models\ProductAttr;
use App\Models\Products;
use App\Models\RefundOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yansongda\Pay\Pay;

class OrdersController extends Controller
{
    /**
     * 创建商城订单
     * @param Request $request
     */
    public function shopOrder(Request $request)
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
            'type' => 1,
            'over_time' => date('Y-m-d H:i:s', time() + 1800),
            'sign_time' => date('Y-m-d H:i:s', time() + 86400 * 7),
            'remark' => $request->remark,
            'price' => $request->price ?? '',
        );
        DB::beginTransaction();
        try {
            $result = Order::create($order);
            if ($result) {
                foreach ($request->product as $key => $value) {
                    $product = Products::where('id', $value['product_id'])->first();
                    $price = $value['price'];
                    $product_attr = ProductAttr::where('id', $value['model_id'])->first();
                    if ($product_attr['stock'] < $value['quantity']) {
                        $data['message'] = $product['product_name'] . "库存不足";
                        return response()->json($data, 401);
                    }
                    OrderSons::create([
                        'order_id' => $result['id'],
                        'size_id' => $value['model_id'],
                        'categories_id' => $product['categories_id'],
                        'product_id' => $value['product_id'],
                        'quantity' => $value['quantity'],
                        'price' => $price,
                    ]);

                    DB::table('product_attrs')->where('id', $value['model_id'])->decrement('stock', $value['quantity']);
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            $data['message'] = "添加失败，检测提交参数";
            $data['list'] = $e;
            return response()->json($data, 401);
        }
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
//                $this->dispatch(new CloseOrder($result, 30));
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
     * 去支付
     * @param Request $request
     */
    public function goPay(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'open_id' => 'required',
        ]);
        $order = Order::where('id', $request->order_id)->first();
        $orderInfo = [
            'out_trade_no' => $order['no'],
            'description' => $order['no'],
            'amount' => [
                'total' => (int)($order['price'] * 100),//$order->price
            ],
            'payer' => [
                'openid' => $request->open_id,
            ],
        ];
        $config = config('pay.wechat');
        try {
            $response = Pay::wechat($config)->mp($orderInfo); // APP 支付
            DB::commit();
            $data = $response;
            return response()->json($data, 200);
        } catch (\Exception $e) {
            DB::rollback();
            $data['message'] = '参数有误';
            $data['list'] = $e;
            return response()->json($data, 400);
        }
    }


    /**
     * 我的订单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function myOrder(Request $request)
    {

        if (isset($request->state)) {
            $state = $request->state;
        } else {
            $state = -1;
        }
        $address = $request->user()->order()
            ->where(function ($query) use ($state) {
                if ($state >= 0) {
                    $query->where('state', $state);
                }
            })
            ->with(['orderSon', 'address', 'orderSon.product', 'orderSon.attr'])->orderBy('id', 'desc')->paginate();
        $data['message'] = '我的订单';
        $data['list'] = $address;
        return response()->json($data, 200);

    }


    /**
     * 我的订单详情
     * @param Request $request
     */
    public function myOrderInfo(Request $request)
    {
        $order = Order::with(['orderSon', 'address', 'orderSon.product', 'orderSon.attr'])
            ->where('id', $request->id)
            ->orderBy('id', 'desc')
            ->first();
        foreach ($order->orderSon as $key => $value) {
            $refund = DB::table('refund_orders')->where('order_son_id', $value->id)->first();
            if ($refund) {
                $value->refund_id = $refund?->id;
            } else {
                $value->refund_id = '';
            }
        }
        $data['message'] = '我的订单';
        $data['list'] = $order;
        return response()->json($data, 200);
    }

    /**
     * 我的退换货订单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function myRefundOrder(Request $request)
    {

        if (isset($request->state)) {
            $state = $request->state;
        } else {
            $state = -1;
        }
        $user = $request->user();
        $order = DB::table('refund_orders as order')
            ->leftJoin('orders as orders', 'order.order_id', '=', 'orders.id')
            ->leftJoin('order_sons as order_sons', 'order.order_son_id', '=', 'order_sons.id')
            ->where('order.user_id', $user->id)
            ->where(function ($query) use ($state) {
                if ($state >= 0) {
                    $query->where('order_sons.state', $state);
                }
            })
            ->select(['order.*', 'order_sons.state as  son_state', 'order_sons.pro_id', 'order_sons.size_id', 'order_sons.quantity', 'orders.address_id'])
            ->paginate();
        $state = ['0' => '未退款', '1' => '申请退款中', '2' => '商家已同意退款', '3' => '商家已拒绝退款', '4' => '申请换货中', '5' => '商家已同意换货，等待提交邮寄单号',
            '6' => '换货货物返回中', '7' => '商家已收货', '8' => '申请退货中', '9' => '商家已同意退货，等待提交邮寄单号',
            '10' => '退货货物返回中', '11' => '退货完成', '12' => '商家已拒绝退货', '13' => '商家已拒绝换货', '14' => '商家重新发货', '15' => '买家已签收', '16' => '商家已重新安排发货'];
        foreach ($order as $value) {
            $value->state_info = $state[$value->state];
            //换货信息
            if ($value->son_state == 1) {
                $exchange_goods = DB::table('exchange_goods')->where('order_son_id', $value->order_son_id)->first();
                $product_attrs = DB::table('product_attrs')->where('id', $exchange_goods->size_id)->first();
                $product_attrs->difference = implode(',', json_decode($product_attrs->difference, true));
                $value->refund_attrs = $product_attrs;
            }
            //商品信息
            $product = Products::where('id', $value->pro_id)->first();
            $product->quantity = $value->quantity;//数量
            //商品型号
            $product_attrs = ProductAttr::where('id', $value->size_id)->first();
            $product->product_attrs = $product_attrs;
            $value->product = $product;
            //地址信息
            $address = Address::where('id', $value->address_id)->first();
            $value->address = $address;
            //退货流程详情
            $flowInfo = array();
            $flow = DB::table('refund_flows')->where('order_son_id', $value->order_son_id)->first();
            $flowInfo['time'] = $flow?->created_at;

            $flow_son = DB::table('refund_flow_fons')->where('flow_id', $flow?->id)->get();
            foreach ($flow_son as $k) {
                $k->state_info = $state[$k->state];
            }
            $flowInfo['son'] = $flow_son;
            $value->flow = $flowInfo;

        }

        $data['message'] = '我的退换货订单';
        $data['list'] = $order;
        return response()->json($data, 200);

    }

    /**
     * 退换订单详情
     * @param Request $request
     */
    public function refundInfo(Request $request)
    {

        $order = DB::table('refund_orders as order')
            ->leftJoin('orders as orders', 'order.order_id', '=', 'orders.id')
            ->leftJoin('order_sons as order_sons', 'order.order_son_id', '=', 'order_sons.id')
            ->where('order.id', $request->id)
            ->select(['order.*', 'order_sons.state as  son_state', 'order_sons.pro_id', 'order_sons.size_id', 'order_sons.quantity', 'orders.address_id'])
            ->first();
        $state = ['0' => '未退款', '1' => '申请退款中', '2' => '商家已同意退款', '3' => '商家已拒绝退款', '4' => '申请换货中', '5' => '商家已同意换货，等待提交邮寄单号',
            '6' => '换货货物返回中', '7' => '商家已收货', '8' => '申请退货中', '9' => '商家已同意退货，等待提交邮寄单号',
            '10' => '退货货物返回中', '11' => '退货完成', '12' => '商家已拒绝退货', '13' => '商家已拒绝换货', '14' => '商家重新发货', '15' => '买家已签收', '16' => '商家已重新安排发货'];
        $order->state_info = $state[$order->son_state];
        //换货信息
        if ($order->son_state == 1) {
            $exchange_goods = DB::table('exchange_goods')->where('order_son_id', $order->order_son_id)->first();
            $product_attrs = DB::table('product_attrs')->where('id', $exchange_goods->size_id)->first();
            $product_attrs->difference = implode(',', json_decode($product_attrs->difference, true));
            $order->refund_attrs = $product_attrs;
        }
        //商品信息
        $product = Products::where('id', $order->pro_id)->first();

        $product->quantity = $order->quantity;//数量
        //商品型号
        $product_attrs = ProductAttr::where('id', $order->size_id)->first();
        $product->product_attrs = $product_attrs;
        $order->product = $product;
        //地址信息
        $address = Address::where('id', $order->address_id)->first();
        $order->address = $address;
        //退货流程详情
        $flowInfo = array();
        $flow = DB::table('refund_flows')->where('order_son_id', $order->order_son_id)->first();
        $flowInfo['time'] = $flow?->created_at;

        $flow_son = DB::table('refund_flow_fons')->where('flow_id', $flow?->id)->get();
        foreach ($flow_son as $k) {
            $k->state_info = $state[$k->state];
        }
        $flowInfo['son'] = $flow_son;
        $order->flow = $flowInfo;
        $data['message'] = '退换货订单详情';
        $data['list'] = $order;
        return response()->json($data, 200);
    }

    /**
     * 确认收货
     * @param Request $request
     */
    public function confirmReceipt(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
        ]);
        $order = Order::where('id', $request->order_id)->first();
        if ($order['state'] != 2) {
            $data['message'] = '发货状态不正常';
            return response()->json($data, 400);
        }
        DB::table('shop_orders')->where('id', $request->order_id)->update(['state' => 3]);
        $data['message'] = '确认收货';
        return response()->json($data, 200);
    }

    /**
     * 申请退款
     * @param Order $order
     */
    public function applyRefund(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'refund_reason' => 'required',
        ]);
        $order = Order::where('id', $request->order_id)->first();
        if ($order['pay_status'] != 1) {
            $data['message'] = '订单未支付';
            return response()->json($data, 400);
        }
        if ($order['refund'] != 0) {
            $data['message'] = '订单以申请退款，请勿重复提交';
            return response()->json($data, 400);
        }
        // 将订单退款状态改为已申请退款
        DB::table('shop_orders')->where('id', $request->order_id)
            ->update([
                'refund' => 1,
                'refund_reason' => $request->refund_reason,
            ]);
        $data['message'] = '申请退款成功';
        return response()->json($data, 200);
    }

    /**
     * 申请换货
     * @param Order $order
     */
    public function exchangeGoods(Request $request)
    {
        $request->validate([
            'order_son_id' => 'required',
            'refund_reason' => 'required',
        ]);
        $user = $request->user();
        $order_son = OrderSons::where('id', $request->order_son_id)->first();
        if ($order_son['status'] != 0) {
            $data['message'] = '该商品已申请退/换货';
            return response()->json($data, 400);
        }
        $order = Order::where('id', $order_son['order_id'])->first();
        if ($order['pay_status'] != 1) {
            $data['message'] = '订单未支付';
            return response()->json($data, 400);
        }

        $product = Products::where('id', $order_son['product_id'])->first();
        $product_attr = ProductAttr::where('id', $request->model_id)->first();
        if ($product_attr['stock'] < $request->quantity) {
            $data['message'] = $product['name'] . "库存不足";
            return response()->json($data, 401);
        }
        Exchange_goods::create([
            'size_id' => $request->model_id,
            'order_son_id' => $request->order_son_id,
        ]);
        OrderSons::where('id', $request->order_son_id)
            ->update([
                'state' => 1
            ]);

        //添加换货单
        RefundOrder::create([
            'no' => $this->findAvailableNo(),
            'order_id' => $order['id'],
            'user_id' => $user->id,
            'order_son_id' => $order_son['id'],
            'address_id' => $request->address_id,
            'freight_state' => $request->freight_state,
            'return_way' => $request->return_way,
            'refund_reason' => $request->refund_reason,
            'refund_image' => $request->refund_image,
            'refund_describe' => $request->refund_describe,
            'state' => 4,
        ]);
        DB::table('refund_flows')->insertGetId([
            'order_son_id' => $order_son['id'],
            'created_at' => date('Y-m-d H:i:s', time())
        ]);
        $this->refund_flow($order_son['id'], 4, '等待商家审核');
        $data['message'] = '申请换货成功';
        return response()->json($data, 200);
    }

    /**
     * 提交返回单号（换货）
     * @param Request $request
     */
    public function submitReturnOdd(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'refund_no' => 'required',
        ]);
        $order = RefundOrder::where('id', $request->id)->first();
        if (empty($order)) {
            $data['message'] = '换货单不存在';
            return response()->json($data, 400);
        }

        DB::table('refund_orders')->where('id', $request->id)
            ->update([
                'state' => 6,
                'express_company' => $request?->express_company,//物流公司
                'refund_no' => $request->refund_no,//退货单号
            ]);
        $this->refund_flow($order['order_son_id'], 6, '快递单号：' . $request->refund_no);
        $data['message'] = '单号提交成功';
        return response()->json($data, 200);
    }

    /**
     * 申请退货
     * @param Order $order
     */
    public function refundGoods(Request $request)
    {
        $request->validate([
            'order_son_id' => 'required',
            'refund_reason' => 'required',
        ]);
        $user = $request->user();
        $order_son = OrderSons::where('id', $request->order_son_id)->first();
        if ($order_son['status'] != 0) {
            $data['message'] = '该商品已申请退/换货';
            return response()->json($data, 400);
        }
        $order = Order::where('id', $order_son['order_id'])->first();
        if ($order['pay_status'] != 1) {
            $data['message'] = '订单未支付';
            return response()->json($data, 400);
        }
        OrderSons::where('id', $request->order_son_id)
            ->update([
                'state' => 2
            ]);
        //添加退货单
        RefundOrder::create([
            'no' => $this->findAvailableNo(),
            'order_id' => $order['id'],
            'user_id' => $user->id,
            'order_son_id' => $order_son['id'],
            'address_id' => $request->address_id,
            'freight_state' => $request->freight_state,
            'return_way' => $request->return_way,
            'refund_reason' => $request->refund_reason,
            'refund_image' => $request->refund_image,
            'refund_describe' => $request->refund_describe,
            'state' => 8,
        ]);
        DB::table('refund_flows')->insertGetId([
            'order_son_id' => $order_son['id'],
            'created_at' => date('Y-m-d H:i:s', time())
        ]);
        $this->refund_flow($order_son['id'], 8, '等待商家审核');
        $data['message'] = '申请退货成功';
        return response()->json($data, 200);
    }

    /**
     * 提交返回单号（退货）
     * @param Request $request
     */
    public function returnOdd(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'refund_no' => 'required',
        ]);
        $order = RefundOrder::where('id', $request->id)->first();
        if (empty($order)) {
            $data['message'] = '退货单不存在';
            return response()->json($data, 400);
        }

        DB::table('refund_orders')->where('id', $request->id)
            ->update([
                'state' => 10,
                'express_company' => $request?->express_company,//物流公司
                'refund_no' => $request->refund_no,//退货单号
            ]);
        $this->refund_flow($order['order_son_id'], 10, '快递单号：' . $request->refund_no);
        $data['message'] = '单号提交成功';
        return response()->json($data, 200);
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

    public function refund_flow($order_son_id, $state, $detail)
    {
        $refund_flow = DB::table('refund_flows')->where('order_son_id', $order_son_id)->first();

        $refund = array(
            'flow_id' => $refund_flow->id,
            'state' => $state,
            'detail' => $detail,
            'created_at' => date('Y-m-d H:i:s', time())
        );
        DB::table('refund_flow_fons')->insert($refund);
    }
}
