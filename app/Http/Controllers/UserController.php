<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserController extends Controller
{
    /**
     * 使用者登入
     *
     * @param Request $request
     * @return void
     */
    public static function login(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'userAccount' => 'required|string|exists:user,u_account',
                    'userPassword' => 'required|string|between:4,15',
                ]
            );

            if ($validator->fails()) {
                return ApiController::sendApiResponse($validator->errors(), 400, [], 'Please check your input.');
            }

            $userInfo = User::find($request->input('userAccount'));

            if (Hash::check($request->input('userPassword'), $userInfo->u_password)) {
                $jwtPayload['userAccount'] = $userInfo->u_account;
                $jwtPayload['userName'] = $userInfo->u_name;

                $jwt = JwtController::generateJwt($jwtPayload);

                $response['token'] = $jwt;
                $response['payload'] = JwtController::decodeJwtPayload($jwt);

                return ApiController::sendApiResponse($response, 200, [], 'Login success.');
            } else {
                return ApiController::sendApiResponse(null, 400, [], 'Incorrect password.');
            }
        } catch (Throwable $th) {
            return ApiController::sendApiResponse(null, 500, [], 'Server error.');
        }
    }

 /**
     * 使用者註冊
     *
     * @param Request $request
     * @return void
     */
    public static function addUser(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'userAccount' => 'required|unique:user,u_account|between:4,15|string',
                    'userPassword' => 'required|string|between:4,15',
                    'userName' => 'required|string|between:1,50',
                ]
            );

            if ($validator->fails()) {
                return ApiController::sendApiResponse($validator->errors(), 400, [], 'Please check your input.');
            }

            DB::transaction(function () use ($request) {
                $userInfo = new User;
                $userInfo->u_account = $request->input('userAccount');
                $userInfo->u_name = $request->input('userName');
                $userInfo->u_password = Hash::make(($request->input('userPassword')));
                $userInfo->save();
            });

            return ApiController::sendApiResponse(null, 201, [], 'Registered success.');
        } catch (Throwable $th) {
            return ApiController::sendApiResponse(null, 500, [], 'Server error.');
        }
    }
}
