<?php

namespace App\Admin\Controllers;

use App\Models\Categories;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class CategoryController extends AdminController
{


    protected $title = '商品分类';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Categories(), function (Grid $grid) {
//            $grid->id('ID')->bold()->sortable();
            $grid->name->tree(); // 开启树状表格功能
            $grid->updated_at->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('name');
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
        return Show::make($id, new Categories(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('pid');
            $show->field('picture');
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
        return Form::make(new Categories(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->select('pid', '上级')->options(Categories::selectOptions());
            $form->image('picture');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
