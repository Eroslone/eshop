<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\SeckillProduct;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class SeckillProductController extends AdminController
{


    protected $title = '秒杀管理';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new SeckillProduct(['product']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('product.product_name','商品名称');
            $grid->column('start_at');
            $grid->column('end_at');
            $grid->column('price','价格');
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
        return Show::make($id, new SeckillProduct(), function (Show $show) {
            $show->field('id');
            $show->field('product_id');
            $show->field('start_at');
            $show->field('end_at');
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
        return Form::make(new SeckillProduct(), function (Form $form) {
            $form->display('id');
            $form->select('product_id','产品')->options('product_info')->required();
            $form->datetime('start_at','开始时间');
            $form->datetime('end_at','结束时间');
            $form->decimal('price','价格')->default(0.00);
            $form->number('amount','数量');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
