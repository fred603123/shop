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

            $allCommodity = Commodity::simplePaginate(4);

            return view('commodity', ['allCommodity' => $allCommodity]);
        } catch (Throwable $th) {
            return ApiController::sendApiResponse($th->getMessage(), 500, [], 'Server error!');
        }
    }

    public static function searchCommodity(Request $request, $commodityId = '')
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
                return view('searchCommodity', ['errorMessage' => $errorMessage]);
            }

            if (empty($request->session()->get('searchName'))) {
                session()->put('searchName', $request->input('commodityName'));
            }

            $searchCommodity = Commodity::where('c_name', 'like', '%' . $request->session()->get('searchName') . '%')
                ->simplePaginate(4);

            return view('search', ['searchCommodity' => $searchCommodity]);
        } catch (Throwable $th) {
            return ApiController::sendApiResponse($th->getMessage(), 500, [], 'Server error!');
        }
    }
}
