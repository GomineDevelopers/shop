<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function store(UserRequest $request, User $user)
    {
        $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData){
            abort(403,'验证码失效');
        }

        if (!hash_equals($verifyData['code'],$request->verification_code)){
            throw new AuthenticationException('验证码不正确');
        }

        if (!hash_equals($verifyData['phone'],$request->phone)){
            throw new AuthenticationException('手机号错误');
        }

        $user = User::create([
            'name'=>$request->name,
            'phone'=>$verifyData['phone'],
            'password'=>bcrypt($request->password),
        ]);

        \Cache::forget($request->verification_key);

        return new UserResource($user);
    }
}
