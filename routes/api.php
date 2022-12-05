<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\IndexController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\SeckillProductController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\CollectiveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthorizationsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {

        Route::middleware('throttle:' . config('api.rate_limits.sign'))
            ->group(function () {
                Route::post('store', [UsersController::class, 'store']); // 注册
                Route::post('login', [UsersController::class, 'login']); // 登录
                Route::put('authorizations/current', [AuthorizationsController::class, 'update']);// 刷新token
                Route::delete('authorizations/current', [AuthorizationsController::class, 'destroy']);// 删除token
            });

        Route::middleware('throttle:' . config('api.rate_limits.access'))
            ->group(function () {
                // 游客可以访问的接口
                Route::get('test', [IndexController::class, 'test']); // test
//                Route::get('demo', [IndexController::class, 'demo']); // test
                Route::get('areaList', [AreaController::class, 'areaList']); // 全国省市区列表
                Route::get('provinceList', [AreaController::class, 'provinceList']); // 全国省份列表
                Route::get('cityList', [AreaController::class, 'cityList']); // 某省份包含的市列表
                Route::get('districtList', [AreaController::class, 'districtList']); // 某市包含的区列表
                //商品分类列表
                Route::post('productType', [ProductsController::class, 'productType']);
                //商品分类列表
                Route::post('productTypeSub', [ProductsController::class, 'productTypeSub']);
                //商品列表
                Route::post('product', [ProductsController::class, 'product']);
                //商品详情
                Route::post('productInfo', [ProductsController::class, 'info']);
                //秒杀列表
                Route::post('seckillList', [SeckillProductController::class, 'seckillList']);
                //拼团列表
                Route::post('collectiveList',[CollectiveController::class,'collectiveList']);
                // 登录后可以访问的接口
                Route::middleware('auth:api')->group(function () {
//                    Route::get('user', [UserController::class, 'me']); // 当前登录用户信息
//                    Route::resource('feedback', FeedbackController::class); // 问题反馈
                    //添加地址
                    Route::post('address', [AddressController::class, 'address']);
                    //我的地址
                    Route::post('myAdd', [AddressController::class, 'myAdd']);
                    //查看地址
                    Route::post('addInfo', [AddressController::class, 'addInfo']);
                    //修改地址
                    Route::post('updAddress', [AddressController::class, 'updAddress']);
                    //删除地址
                    Route::post('deladd', [AddressController::class, 'deladd']);
                    //创建订单
                    Route::post('shopOrder', [OrdersController::class, 'shopOrder']);
                    //去支付
                    Route::post('goPay', [OrdersController::class, 'goPay']);
                    //我的订单
                    Route::post('myOrder', [OrdersController::class, 'myOrder']);
                    //确认收货
                    Route::post('confirmReceipt', [OrdersController::class, 'confirmReceipt']);
                    //申请退款
                    Route::post('applyRefund', [OrdersController::class, 'applyRefund']);
                    //申请换货
                    Route::post('exchangeGoods', [OrdersController::class, 'exchangeGoods']);
                    //提交返回单号（换货）
                    Route::post('submitReturnOdd', [OrdersController::class, 'submitReturnOdd']);
                    //申请退货
                    Route::post('refundGoods', [OrdersController::class, 'refundGoods']);
                    //提交返回单号（退货）
                    Route::post('returnOdd', [OrdersController::class, 'returnOdd']);
                    //创建秒杀订单
                    Route::post('seckillOrder', [SeckillProductController::class, 'seckillOrder']);
                    //创建拼团订单
                    Route::post('collectiveOrder',[CollectiveController::class,'collectiveOrder']);
                    //加入已有拼团订单
                    Route::post('collectiveJoin',[CollectiveController::class,'collectiveJoin']);
                    //查看拼团状态
                    Route::get('collectiveStatus',[CollectiveController::class,'collectiveStatus']);
                    //查看拼团订单详情
                    Route::get('collectiveDetails',[CollectiveController::class,'collectiveDetails']);
                    //支付拼团订单
                    Route::post('collectivePay',[CollectiveController::class,'collectivePay']);
                    //根据商品id获取拼团列表
                    Route::post('productCollective',[CollectiveController::class,'getCollectiveListByPruductId']);
                    //我的拼团列表
                    Route::post('myCollective',[CollectiveController::class,'myCollectiveLists']);
                    //拼团人数不足自动补齐(虚拟成团)
                    Route::post('autoComplete',[CollectiveController::class,'autoCompleteCollective']);
                    //获取分销商列表
                    Route::get('dietributorList',[DistributorController::class,'getDistributorLists']);
                });
            });
    });
