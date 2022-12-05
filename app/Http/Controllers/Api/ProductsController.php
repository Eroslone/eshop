<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

    /**
     * 产品类型
     * @param Request $request
     */
    public function productType(Request $request)
    {
        $type = DB::table('categories')->where('pid', 0)->get();
        $data['message'] = "商品分类列表";
        $data['list'] = $type;
        return response()->json($data, 200);
    }

    /**
     * 产品下级类型
     * @param Request $request
     */
    public function productTypeSub(Request $request)
    {
        $type = DB::table('categories')->where('pid', $request->id)->get();
        foreach ($type as $value) {
            $sub = DB::table('categories')->where('pid', $value->id)->get();
            $value->sub = $sub;
        }
        $data['message'] = "商品分类列表";
        $data['list'] = $type;
        return response()->json($data, 200);
    }


    /**
     * 商品列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function product(Request $request)
    {
        if (!empty($request->type_id)) {
            $type_id = $request->type_id;
        } else {
            $type_id = 0;
        }

        if (!empty($request->title)) {
            $title = $request->title;
        } else {
            $title = '';
        }
        $sort = 'id';
        $sort_variable = 'asc';
        if (!empty($request->time)) {
            $sort_variable = $request->time;
        }
        if (!empty($request->price)) {
            $sort = 'price';
            $sort_variable = $request->price;
        }
        $result = DB::table('products')
            ->leftJoin('categories', 'products.categories_id', '=', 'categories.id')
            ->where(function ($query) use ($type_id, $title) {
                if (!empty($type_id)) {
                    $query->where('products.categories_id', $type_id);
                }
                if (!empty($title)) {
                    $query->where('products.product_name', 'like', '%' . $title . '%');
                }
            })
            ->where('state', 1)
            ->select('products.id', 'products.product_name', 'products.price', 'categories.name as type', 'products.pictures')
            ->orderBy($sort, $sort_variable)
            ->get()->toArray();
        foreach ($result as $key => $value) {
            $value->picture_url = config('app.url') . "/storage/" . json_decode($value->pictures)[0];
        }
        $data['message'] = "商品列表";
        $data['list'] = $result;
        return response()->json($data, 200);
    }

    /**
     * 商品详情
     * @param Request $request
     */
    public function info(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $result = DB::table('products')
            ->leftJoin('categories', 'products.categories_id', '=', 'categories.id')
            ->where('products.id', $request->id)
            ->select('products.id', 'products.product_name', 'price', 'original_price', 'categories.name as type', 'products.pictures', 'describe', 'attr', 'number')
            ->first();
        $productAttr = DB::table('product_attrs')->where('product_id', $result->number)
            ->where('stock', '>', 0)
            ->where('delete', 0)
            ->select('id', 'price', 'stock', 'difference')
            ->get();
        if ($productAttr) {
            foreach ($productAttr as $key => $value) {
                $value->difference = json_decode($value->difference);
            }
        }
        $pictureList = json_decode($result->pictures);
        foreach ($pictureList as $key => $value) {
            $pictureList[$key] = config('app.url') . "/storage/" . $value;
        }
        $attr = json_decode($result->attr);
        if ($attr) {
            $attrs = array_unique(array_column($attr, 'attr_id'));
            $attrList = array();
            foreach ($attrs as $key => $value) {
                $attributes = DB::table('attributes')->where('id', $value)->select('attr_name')->first();
                $attributes_list = array('attr' => $attributes->attr_name);
                foreach ($attr as $k => $v) {
                    if ($v->attr_id == $value) {
                        $attributes_list['item'][] = array(
                            'spec_name' => DB::table('specifications')->select('spec_name')->where('id', $v->spec_id)->first()->spec_name,
                            'price' => $v->price,
                            'inventory' => $v->inventory
                        );
                    }
                }
                $attrList[] = $attributes_list;
            }
            $result->attr = $attrList;
        }

        $result->pictures = $pictureList;
        $result->difference = $productAttr;
        $data['message'] = "商品详情";
        $data['list'] = $result;
        return response()->json($data, 200);
    }

    public function productAttr($attr, $number)
    {

        $attrs = array_unique(array_column($attr, 'attr_id'));

        $attrList = array();
        foreach ($attrs as $key => $value) {
            $attributes = DB::table('attributes')->where('id', $value)->select('attr_name')->first();
            $attributes_list = array('attr' => $attributes->attr_name);

            foreach ($attr as $k => $v) {
                if ($v['attr_id'] == $value) {
                    $attributes_list['item'][] = array(
                        'spec_name' => DB::table('specifications')->select('spec_name')->where('id', $v['spec_id'])->first()->spec_name,
                        'price' => $v['price'],
                        'stock' => $v['inventory']
                    );
                }
            }
            $attrList[] = $attributes_list;
        }
        $list = [];
        $lsList = [];
        $this->attr($attrList, $list, 0, $lsList);
        DB::table('product_attrs')->where('product_id', $number)->update(['delete' => 1]);
        foreach ($list as $i => $item) {
            $product = array();
            $product['product_id'] = $number;
            $product['price'] = array_sum($item['price']);
            $product['stock'] = (int)min($item['stock']);
            $product['difference'] = json_encode($item['difference']);
            DB::table('product_attrs')->insert($product);
        }
        return $list;
    }

    public function attr($attr, &$attrList, $num, &$lsList, $tier = true)
    {

        foreach ($attr[$num]['item'] as $key => $value) {
            $lsList['price'][] = $value['price'];
            $lsList['stock'][] = $value['stock'];
            $lsList['difference'][] = $value['spec_name'];
            if (!empty($attr[$num + 1])) {
                $this->attr($attr, $attrList, $num + 1, $lsList, false);
            }
            if (!empty($lsList)) {
                if ($tier) {
                    $lsList = [];
                } else {
                    if (count($lsList['price']) == count($attr)) {
                        $attrList[] = $lsList;
                    }
                    array_splice($lsList['price'], $num, 1);
                    array_splice($lsList['stock'], $num, 1);
                    array_splice($lsList['difference'], $num, 1);
                }
            }
        }
    }
}
