<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\CollectiveLog;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class CollectiveLogController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new CollectiveLog(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('collective_id');
            $grid->column('user_id');
            $grid->column('store_id');
            $grid->column('goods_id');
            $grid->column('discount');
            $grid->column('need');
            $grid->column('status');
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
        return Show::make($id, new CollectiveLog(), function (Show $show) {
            $show->field('id');
            $show->field('collective_id');
            $show->field('user_id');
            $show->field('store_id');
            $show->field('goods_id');
            $show->field('discount');
            $show->field('need');
            $show->field('status');
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
        return Form::make(new CollectiveLog(), function (Form $form) {
            $form->display('id');
            $form->text('collective_id');
            $form->text('user_id');
            $form->text('store_id');
            $form->text('goods_id');
            $form->text('discount');
            $form->text('need');
            $form->text('status');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
