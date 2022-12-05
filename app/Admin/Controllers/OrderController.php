<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Order;
use App\Models\Order as Orders;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;


class OrderController extends AdminController
{

    protected $title = '订单管理';


    public function show($id, Content $content)
    {
        return $content
            ->header('查看订单')
            // body 方法可以接受 Laravel 的视图作为参数
            ->body(view('admin.orders.show', ['order' => Orders::find($id)]));
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Order(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('no');
            $grid->column('remark');
            $grid->column('price');
            $grid->column('state')->using(['0' => '未付款，未发货', '1' => '已付款，未发货', '2' => '已付款，已发货', '3' => '已收货', '-1' => '已取消'])->label([
                0 => 'danger',
                1 => 'success',
                2 => 'success',
                3 => 'success',
                -1 => 'danger',
            ]);
            $grid->column('refund')->using(['0' => '未退款', '1' => '申请退款中', '2' => '商家已同意退款', '3' => '商家已拒绝退款', '4' => '申请换货中', '5' => '商家已同意换货，等待提交邮寄单号',
                '6' => '换货货物返回中', '7' => '换货完成', '8' => '申请退货中', '9' => '商家已同意退货，等待提交邮寄单号', '10' => '退货货物返回中', '11' => '退货完成', '12' => '商家已拒绝退货', '13' => '商家已拒绝换货']);
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Order(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('no');
            $show->field('address_id');
            $show->field('remark');
            $show->field('price');
            $show->field('state');
            $show->field('paid_at');
            $show->field('payment_method');
            $show->field('pay_status');
            $show->field('over_time');
            $show->field('express_company');
            $show->field('express_no');
            $show->field('refund');
            $show->field('refund_reason');
            $show->field('refund_no');
            $show->field('refuse_reason');
            $show->field('freight_state');
            $show->field('return_way');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Order(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('no');
            $form->text('address_id');
            $form->text('remark');
            $form->text('price');
            $form->text('state');
            $form->text('paid_at');
            $form->text('payment_method');
            $form->text('pay_status');
            $form->text('over_time');
            $form->text('express_company');
            $form->text('express_no');
            $form->text('refund');
            $form->text('refund_reason');
            $form->text('refund_no');
            $form->text('refuse_reason');
            $form->text('freight_state');
            $form->text('return_way');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
