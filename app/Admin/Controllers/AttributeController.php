<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Attributes;
use App\Models\Attributes as Attr;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class AttributeController extends AdminController
{

    protected $title = '属性';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Attributes(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('attr_name');
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
        return Show::make($id, new Attributes(), function (Show $show) {
            $show->field('id');
            $show->field('attr_name');
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
        return Form::make(new Attributes(), function (Form $form) {
            $form->display('id');
            $form->text('attr_name');
        });
    }

    public function attr(Request $request)
    {
        $q = $request->get('q');
        return Attr::where('attr_name', 'like', "%$q%")->select('id', 'attr_name as text')->get();
    }
}
