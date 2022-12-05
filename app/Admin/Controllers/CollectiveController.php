<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Collective;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class CollectiveController extends AdminController
{
    protected $title = '拼团管理';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Collective(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('store_id');
            $grid->column('goods_id');
            $grid->column('discount');
            $grid->column('need');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
            $grid->showBatchActions();
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
        return Show::make($id, new Collective(), function (Show $show) {
            $show->field('id');
            $show->field('store_id');
            $show->field('goods_id');
            $show->field('discount');
            $show->field('need');
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
        return Form::make(new Collective(), function (Form $form) {
            $form->display('id');
            $form->text('store_id');
            $form->text('goods_id');
            $form->text('discount');
            $form->text('need');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
