<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * 手机号注册用户
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'phone' => 'required|phone:CN,mobile|unique:users,mobile',
//            'verify_code' => 'required|numeric',
            'name' => 'required',
        ]);
        $mobile = $request->phone;
        $name = $request->name;
        $password = $request->password;
//        $key = 'verificationCode_' . $mobile;
//
//        $verifyData = \Cache::get($key);
//        if (!$verifyData) {
//            $data['message'] = "短信验证码已失效！";
//            return response()->json($data, 403);
//        }
//        if (!hash_equals($verifyData['code'], $request->verify_code)) {
//            $data['message'] = "短信验证码不正确！";
//            return response()->json($data, 403);
//        }
        // 创建用户 TODO
        $user = User::create([
            'mobile' => $mobile,
            'name' => $name,
            'password' => bcrypt($password),
        ]);
        // 清除验证码缓存
//        \Cache::forget($key);
        $data['message'] = "注册成功";
        return response()->json($data, 200);
    }

    /**
     * 登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|phone:CN,mobile',
            'password' => 'required',
        ]);
        $mobile = $request->input('phone');
        $password = $request->input('password');
        $user = User::where('mobile', $mobile)->first();
        if ($user) {
            if (!Hash::check($password, $user->password)) {
                return response()->json(['code' => 400, 'msg' => '密码错误']);
            } else {
                $token = $user->createToken('Token Name')->accessToken;
                return response()->json(['code' => 200, 'msg' => '登录成功', 'token' => $token, 'user' => $user]);
            }
        } else {
            return response()->json(['code' => 400, 'msg' => '账号不存在']);
        }

    }
}
