<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class AddressController extends Controller
{
    /**
     * 添加地址
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function address(Request $request)
    {
        $request->validate([
            'recipients' => 'required',
            'phone' => 'required',
            'province_name' => 'required',
            'city_name' => 'required',
            'district_name' => 'required',
            'address' => 'required',
        ]);
        $user = $request->user();
        $address = array(
            'user_id' => $user->id,
            'recipients' => $request->recipients,
            'phone' => $request->phone,
            'province_name' => $request->province_name,
            'city_name' => $request->city_name,
            'district_name' => $request->district_name,
            'address' => $request->address,
        );
        if (!empty($request->default)) {
            $address['default'] = 1;
            QueryBuilder::for(Address::class)->update(['default' => 0]);
        }
        $cart = Address::create($address);
        if ($cart) {
            $data['message'] = '添加成功';
            return response()->json($data, 200);
        } else {
            $data['message'] = '添加失败，检查参数';
            return response()->json($data, 401);
        }
    }

    /**
     * 我的地址
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function myAdd(Request $request)
    {
        $address = $request->user()->address()->orderBy('default', 'desc')->get();
        $data['message'] = '我的地址';
        $data['list'] = $address;
        return response()->json($data, 200);
    }

    /**
     * 查看地址信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addInfo(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $address = Address::where('id', '=', $request->id)
            ->first();
        $data['message'] = '地址信息';
        $data['list'] = $address;
        return response()->json($data, 200);
    }

    /**
     * 修改地址
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updAddress(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'recipients' => 'required',
            'phone' => 'required',
            'province_name' => 'required',
            'city_name' => 'required',
            'district_name' => 'required',
            'address' => 'required',
        ]);
        $user = $request->user();
        $address = array(
            'recipients' => $request->recipients,
            'phone' => $request->phone,
            'province_name' => $request->province_name,
            'city_name' => $request->city_name,
            'district_name' => $request->district_name,
            'address' => $request->address,
        );
        if (!empty($request->default)) {
            $address['default'] = 1;
            QueryBuilder::for(Address::class)->update(['default' => 0]);
        }
        $cart = Address::where('id', $request->id)->update($address);
        if ($cart) {
            $data['message'] = '修改成功';
            return response()->json($data, 200);
        } else {
            $data['message'] = '修改失败，检查参数';
            return response()->json($data, 401);
        }
    }

    /**
     * 删除地址信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deladd(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $address = Address::where('id', $request->id)->delete();
        if ($address) {
            $data['message'] = '删除成功';
            return response()->json($data, 200);
        } else {
            $data['message'] = '删除失败，检查参数';
            return response()->json($data, 401);
        }
    }
}
