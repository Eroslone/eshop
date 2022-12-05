<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Specifications;
use App\Models\Specifications as Spec;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class SpecificationController extends AdminController
{

    protected $title = '规格';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Specifications(['attributes']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('attributes.attr_name','属性');
            $grid->column('spec_name');
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
        return Show::make($id, new Specifications(), function (Show $show) {
            $show->field('id');
            $show->field('attributes_id');
            $show->field('spec_name');
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
        return Form::make(new Specifications(), function (Form $form) {
            $form->display('id');
            $form->select('attributes_id')->options('attribute')->required();
            $form->text('spec_name');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }

    public function spec(Request $request)
    {
        $q = $request->get('q');
        $school_list=array();
        $school=Spec::where('attributes_id',  $q)->select('id', 'spec_name as text')->get()->toArray();
        return array_merge_recursive($school_list,$school);
    }
}
