<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commodity;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CommodityController extends Controller
{
    public static function getCommodity(Request $request, $commodityId = '')
    {
        try {
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

            $allCommodity = Commodity::orderby('c_id', 'asc')->simplePaginate(4);

            return view('commodity', ['allCommodity' => $allCommodity]);
        } catch (Throwable $th) {
            return ApiController::sendApiResponse($th->getMessage(), 500, [], 'Server error!');
        }
    }

    public static function searchCommodity(Request $request)
    {
        try {
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

            if ($request->input('commodityName') != null || empty(session()->get('searchName'))) {
                session()->put('searchName', $request->input('commodityName'));
            }

            $searchCommodity = Commodity::where('c_name', 'like', '%' . session()->get('searchName') . '%')
                ->orderby('c_id', 'asc')
                ->simplePaginate(4);

            return view('search', ['searchCommodity' => $searchCommodity]);
        } catch (Throwable $th) {
            return ApiController::sendApiResponse($th->getMessage(), 500, [], 'Server error!');
        }
    }
}
