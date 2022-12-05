<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Collective;
use App\Models\CollectiveLog;
use App\Models\Order;
use App\Models\OrderSons;
use App\Models\ProductAttr;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Resources\CollectiveResource;
use Illuminate\Support\Facades\DB;
use Yansongda\Pay\Pay;

class CollectiveController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *拼团商品列表
     * @param  \App\Models\Collective  $collective
     * @return \Illuminate\Http\Response
     */
    public function collectiveList(Request $request)
    {
        $collectives = Products::where('is_groupbuy',1)->orderByDesc('created_at')->paginate();

        return CollectiveResource::collection($collectives);

    }
    /**
     * Remove the specified resource from storage.
     *创建拼团订单信息
     * @param  \App\Models\Collective  $collective
     * @return \Illuminate\Http\Response
     */
    public function collectiveOrder(Request $request)
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
            'type' => 3,
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

                    //collective表新增拼团信息
                    $collective = array(
                        'goods_id' => $value['product_id'],
                        'need' => $value['need'],
                    );
                    $collectiveres = Collective::create($collective);
                    $collectivelog = array(
                        'collective_id' => $collectiveres->id,
                        'user_id' => $user->id,
                        'goods_id' => $value['product_id'],
                        'need' => $value['need'],
                        'status' => 2,
                    );
                    CollectiveLog::create($collectivelog);
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            $data['message'] = "添加失败，检测提交参数";
            $data['list'] = $e;
            return response()->json($data, 401);
        }
        DB::commit();
        $data['message'] = '拼团订单创建成功';
        return response()->json($data, 200);
    }
    /**
     * Remove the specified resource from storage.
     *加入已有拼团订单
     * @param  \App\Models\Collective  $collective
     * @return \Illuminate\Http\Response
     */
    public function collectiveJoin(Request $request)
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
            'type' => 3,
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
                    //collectiveLog表新增拼团信息
                    $collectivelog = array(
                        'collective_id' => $request->collective_id,
                        'user_id' => $user->id,
                        'goods_id' => $value['product_id'],
                        'need' => $value['need'],
                        'status' => 2,
                    );
                    CollectiveLog::create($collectivelog);
                    //判断是否已满团,多久后未满团的是否需要自动补齐
                    $count = CollectiveLog::where('collective_id',$request->collective_id)->count();
                    if ($count >= $value['need']){
                        //修改拼团为已完成
                        CollectiveLog::where('collective_id',$request->collective_id)
                            ->update(['status' => 1]);
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            $data['message'] = "添加失败，检测提交参数";
            $data['list'] = $e;
            return response()->json($data, 401);
        }
        DB::commit();
        $data['message'] = '加入拼团成功!';
        return response()->json($data, 200);
    }
    /**
     * Remove the specified resource from storage.
     *查看拼团状态
     * @param  \App\Models\Collective  $collective
     * @return \Illuminate\Http\Response
     */
    public function collectiveStatus(Request $request)
    {
        $num = CollectiveLog::where('collective_id', $request->collective_id)->count();
        $need = Collective::where('id', $request->collective_id)->first()->need;
        $data['num'] = $num;
        $data['need'] = $need;
        $data['completed'] = round($num / $need * 100,2)."%";
        return response()->json($data, 200);
    }
    /**
     * Remove the specified resource from storage.
     *查看拼团商品详情
     * @param  \App\Models\Collective  $collective
     * @return \Illuminate\Http\Response
     */
    public function collectiveDetails(Request $request)
    {
        $products = Collective::find($request->collective_id)->products;
        return $products;

    }
    /**
     * Remove the specified resource from storage.
     *支付拼团订单
     * @param  \App\Models\Collective  $collective
     * @return \Illuminate\Http\Response
     */
    public function collectivePay(Request $request)
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
     * Remove the specified resource from storage.
     *由产品id获取其拼团订单列表
     * @param  \App\Models\Collective  $collective
     * @return \Illuminate\Http\Response
     */
    public function getCollectiveListByPruductId(Request $request)
    {
        $productid = $request->product_id;
        $collectivelogs = CollectiveLog::query()
            ->where('goods_id',$productid)
            ->where('status',2)
            ->get();
        foreach ($collectivelogs as $collectivelog){
            $collectivelog['collective'] = $collectivelog->collective;
        }
        return response()->json($collectivelogs, 200);
    }
    /**
     * Remove the specified resource from storage.
     *我参与的拼团订单列表
     * @param  \App\Models\Collective  $collective
     * @return \Illuminate\Http\Response
     */
    public function myCollectiveLists(Request $request)
    {
        $user = $request->user();
        $status = $request->status;
        if ($status){
            $collectivelogs = CollectiveLog::where('user_id',$user->id)
                ->where('status',$status)
                ->paginate();
            foreach ($collectivelogs as $collectivelog){
                $collectivelog['collective'] = $collectivelog->collective;
            }
        }
        $data = $collectivelogs;
        return response()->json($data, 200);
    }
    /**
     * Remove the specified resource from storage.
     *人数不足自动补齐拼团(虚拟成团)
     * @param  \App\Models\Collective  $collective
     * @return \Illuminate\Http\Response
     */
    public function autoCompleteCollective(Request $request)
    {
        $collectiveid = $request->collective_id;
        //虚拟成团不生成订单,只对真实买家发货--虚拟用户生成虚拟订单?生成的虚拟订单直接标记为已完成 state:0.待付款 1.待发货 2.待收货 3.已完成 -1.已取消
        $userid = 1;
        $order = array(
            'no' => 'SC' . $this->findAvailableNo(),
            'user_id' => $userid,
            'address_id' => 1,
            'type' => 3,
            'over_time' => date('Y-m-d H:i:s', time() + 1800),
            'sign_time' => date('Y-m-d H:i:s', time() + 86400 * 7),
            'remark' => "虚拟成团订单,不需发货",
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

                    OrderSons::create([
                        'order_id' => $result['id'],
                        'size_id' => $value['model_id'],
                        'categories_id' => $product['categories_id'],
                        'product_id' => $value['product_id'],
                        'quantity' => $value['quantity'],
                        'price' => $price,
                    ]);

                    //collectiveLog表新增拼团信息
                    $collectivelog = array(
                        'collective_id' => $request->collective_id,
                        'user_id' => $userid,
                        'goods_id' => $value['product_id'],
                        'need' => $value['need'],
                        'status' => 2,
                    );
                    CollectiveLog::create($collectivelog);
                    //判断是否已满团,多久后未满团的是否需要自动补齐
                    $count = CollectiveLog::where('collective_id',$request->collective_id)->count();
                    if ($count >= $value['need']){
                        //修改拼团为已完成
                        CollectiveLog::where('collective_id',$request->collective_id)
                            ->update(['status' => 1]);
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            $data['message'] = "添加失败，检测提交参数";
            $data['list'] = $e;
            return response()->json($data, 401);
        }
        DB::commit();
        $data['message'] = '加入拼团成功!';
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
