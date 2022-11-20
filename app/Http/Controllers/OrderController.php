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
    public static function getOrder(Request $request)
    {
        $orderInfo = Order::join('user', 'order.u_account', '=', 'user.u_account')
            ->join('commodity', 'order.c_id', '=', 'commodity.c_id')
            ->select('o_id as id', 'commodity.c_name as commodityName', 'commodity.c_price as commodityPrice')
            ->where('order.u_account', $request->session()->get('userInfo.userAccount'))
            ->orderby('o_id', 'asc')
            ->get();
        return view('order', ['order' => $orderInfo]);
    }

    public static function addOrder(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'CommodityId' => "required|int|exists:commodity,c_id",
                ]
            );

            if ($validator->fails()) {
                $errorMessage = 'Please check your input.';
                return view('login', ['errorMessage' => $errorMessage]);
            }

            DB::transaction(function () use ($request) {
                $orderInfo = new Order;
                $orderInfo->u_account = $request->session()->get('userInfo.userAccount');
                $orderInfo->c_id = $request->input('CommodityId');
                $orderInfo->save();
                return $orderInfo;
            });

            return redirect()->back();
        } catch (Throwable $th) {
            return ApiController::sendApiResponse($th->getMessage(), 500, [], 'Server error!');
        }
    }
}
