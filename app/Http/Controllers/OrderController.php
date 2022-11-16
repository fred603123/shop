<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Commodity;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Throwable;

class OrderController extends Controller
{
    public static function addOrder(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'userAccount' => 'required|string|exists:user,u_account',
                    'CommodityId' => "required|int|exists:commodity,c_id",
                ]
            );

            if ($validator->fails()) {
                return ApiController::sendApiResponse($validator->errors(), 400, [], 'Please check your input!');
            }

            $query = DB::transaction(function () use ($request) {
                $orderInfo = new Order;
                $orderInfo->u_account = $request->input('userAccount');
                $orderInfo->c_id = $request->input('CommodityId');
                $orderInfo->save();
                return $orderInfo;
            });

            return ApiController::sendApiResponse($query, 200, [], 'Create order success!');
        } catch (Throwable $th) {
            return ApiController::sendApiResponse(null, 500, [], 'Server error!');
        }
    }
}
