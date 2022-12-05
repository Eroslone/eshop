<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('attribute', 'AttributeController@attr');// 属性
    $router->get('spec', 'SpecificationController@spec');// 规格
    $router->get('product_info', 'ProductController@product');// 规格
    $router->post('orders/{order}/ship', 'ShopOrderController@ship')->name('orders.ship');//发货
    $router->post('orders/{order}/refund', 'ShopOrderController@handleRefund')->name('orders.handle_refund');//退款
    $router->post('orders/{order}/exchangeGoods', 'ShopOrderController@exchangeGoods')->name('orders.exchangeGoods');//换货
    $router->post('orders/{order}/affirmTake', 'ShopOrderController@affirmTake')->name('orders.affirmTake');//确认返回货物
    $router->post('orders/{order}/refundGoods', 'ShopOrderController@refundGoods')->name('orders.refundGoods');//退货
    $router->post('orders/{order}/affirmRefundTake', 'ShopOrderController@affirmRefundTake')->name('orders.affirmRefundTake');//确认返回货物
    $router->resource('user', UserController::class); // 用户
    $router->resource('product', ProductController::class); // 商品
    $router->resource('category', CategoryController::class); // 商品分类
    $router->resource('attributes', AttributeController::class); // 属性
    $router->resource('specification', SpecificationController::class); // 规格
    $router->resource('order', OrderController::class); //订单
    $router->resource('collective', CollectiveController::class); //拼团
    $router->resource('secKill', SeckillProductController::class); //订单
    $router->get('orders/{order}', 'OrdersController@show')->name('orders.show');
});
