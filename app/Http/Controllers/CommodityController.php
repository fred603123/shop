<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Commodity;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CommodityController extends Controller
{
    public static function getCommodity(Request $request, $commodityId = '')
    {
        try {
            if (empty($request->session()->get('userInfo.userAccount'))) {
                return view('login');
            }

            $requestInput = $request->all();
            $requestInput['commodityId'] = $commodityId;

            $validator = Validator::make(
                $request->all(),
                [
                    'commodityName' => 'string',
                    'commodityId' => 'int|exists:commodity,c_id',
                ]
            );

            if ($validator->fails()) {
                $errorMessage = 'Please check your input.';
                return view('commodity', ['errorMessage' => $errorMessage]);
            }

            $request->session()->put('inDescendingOrder', '1');

            if ($request->has('inDescendingOrder') || !$request->session()->has('inDescendingOrder')) {
                $request->session()->forget('inAscendingOrder');
                $request->session()->put('inDescendingOrder', '1');
                $allCommodity = Commodity::orderby('c_price', 'desc')->simplePaginate(4);
                return view('commodity', ['allCommodity' => $allCommodity]);
            }

            if ($request->has('inAscendingOrder') || $request->session()->has('inAscendingOrder')) {
                $request->session()->forget('inDescendingOrder');
                $request->session()->put('inAscendingOrder', '2');
                $allCommodity = Commodity::orderby('c_price', 'asc')->simplePaginate(4);
                return view('commodity', ['allCommodity' => $allCommodity]);
            }

            $allCommodity = Commodity::orderby('c_price', 'desc')->simplePaginate(4);
            return view('commodity', ['allCommodity' => $allCommodity]);
        } catch (Throwable $th) {
            return ApiController::sendApiResponse($th->getMessage(), 500, [], 'Server error!');
        }
    }

    public static function searchCommodity(Request $request)
    {
        try {
            if (empty($request->session()->get('userInfo.userAccount'))) {
                return view('login');
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'commodityName' => 'string',
                    'commodityId' => 'int|exists:commodity,c_id',
                ]
            );

            if ($validator->fails()) {
                $errorMessage = 'Please check your input.';
                return view('search', ['errorMessage' => $errorMessage]);
            }

            if ($request->input('commodityName') != null || empty($request->session()->get('searchName'))) {
                $request->session()->put('searchName', $request->input('commodityName'));
            }

            $request->session()->put('inDescendingOrder', '1');

            if ($request->has('inDescendingOrder') || !$request->session()->has('inDescendingOrder')) {
                $request->session()->forget('inAscendingOrder');
                $request->session()->put('inDescendingOrder', '1');
                $allCommodity = Commodity::where('c_name', 'like', '%' . $request->session()->get('searchName') . '%')
                    ->orderby('c_price', 'desc')
                    ->simplePaginate(4);
                return view('search', ['searchCommodity' => $allCommodity]);
            }

            if ($request->has('inAscendingOrder') || $request->session()->has('inAscendingOrder')) {
                $request->session()->forget('inDescendingOrder');
                $request->session()->put('inAscendingOrder', '2');
                $allCommodity = Commodity::where('c_name', 'like', '%' . $request->session()->get('searchName') . '%')
                    ->orderby('c_price', 'asc')
                    ->simplePaginate(4);
                return view('search', ['searchCommodity' => $allCommodity]);
            }

            $searchCommodity = Commodity::where('c_name', 'like', '%' . $request->session()->get('searchName') . '%')
                ->orderby('c_price', 'asc')
                ->simplePaginate(4);

            return view('search', ['searchCommodity' => $searchCommodity]);
        } catch (Throwable $th) {
            return ApiController::sendApiResponse($th->getMessage(), 500, [], 'Server error!');
        }
    }
}
