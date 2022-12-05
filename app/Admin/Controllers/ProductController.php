<?php

namespace App\Admin\Controllers;

use App\Models\Categories;
use App\Admin\Repositories\Products;
use App\Models\Products as pro;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;


class ProductController extends AdminController
{


    protected $title = '商品管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Products(['categories']), function (Grid $grid) {
            $grid->withBorder();
            $grid->column('picture_url', __('Photo'))->image('', 100, 100);
            $grid->column('product_name', '商品名称');
            $grid->column('number', '商品编码');
            $grid->column('categories.name', '类型');
            $grid->column('price', '价格');
            $grid->column('sales_volume', '销量');
            $grid->column('state', __('Status'))->using([
                0 => '隐藏',
                1 => '展示',
            ], '未知')->label([
                0 => 'danger',
                1 => 'success',
            ], 'warning');
            $grid->column('is_groupbuy', '是否团购')->using([
                0 => '否',
                1 => '是',
            ], '未知')->label([
                0 => 'danger',
                1 => 'success',
            ], 'warning');
//            $grid->column('group_request','团购人数要求');
            $grid->column('created_at');

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
        return Show::make($id, new Products(), function (Show $show) {
            $show->field('id');
            $show->field('product_name');
            $show->field('number');
            $show->field('pictures');
            $show->field('describe');
            $show->field('type_id');
            $show->field('price');
            $show->field('sales_volume');
            $show->field('state');
            $show->field('attr');
            $show->field('is_groupbuy');
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
        return Form::make(new Products(), function (Form $form) {
            $form->text('product_name', '商品名称');
            $form->text('number', '商品编码');
            $form->multipleImage('pictures', '商品图片')->removable()->required();
            $form->editor('describe', "商品描述");
            $form->select('categories_id', '类型')->options(Categories::selectOptions());
            $form->decimal('price', __('Price'))->default(0.00);
            $form->decimal('original_price', '原价')->default(0.00);
            $states = [
                'on' => ['value' => 1, 'text' => '展示', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '隐藏', 'color' => 'danger'],
            ];
            $form->number('sales_volume', '销量')->default(0);
            $form->switch('state', '是否展示');
            $form->switch('is_groupbuy', '是否团购');
            $form->number('group_request', '团购人数要求');
            $form->table('attr', '属性规格', function ($table) {
                $table->select('attr_id', '属性')->options('attribute')->load('spec_id', 'spec');
                $table->select('spec_id', '规格');
                $table->decimal('price', '价格');
                $table->number('inventory', '库存');

            });
        });
    }

    public function product(Request $request)
    {
        $q = $request->get('q');
        return pro::where('product_name', 'like', "%$q%")->select('id', 'product_name as text','pictures')->get();
    }
}
