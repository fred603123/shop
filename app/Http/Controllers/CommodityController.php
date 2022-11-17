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
                return ApiController::sendApiResponse($validator->errors(), 400, [], 'Please check your input!');
            }

            // if (empty($commodityId) && empty($request->all())) {
            //     $val = Commodity::paginate(4);
            //     return view('commodity', ['val' => $val]);
            //     // return ApiController::sendApiResponse(Commodity::all()->paginate(4), 200, [], 'Search all locations success!');
            // }

            // if (!empty($commodityId)) {
            //     $query = Commodity::select('c_id as CommodityId', 'c_name as CommodityName', 'c_price as CommodityPrice')
            //         ->where('c_id', $commodityId)
            //         ->paginate(4);
            //     return ApiController::sendApiResponse($query, 200, [], 'Search success!');
            // }

            // if ($request->has('commodityName')) {
            //     $query = Commodity::select('c_id as CommodityId', 'c_name as CommodityName', 'c_price as CommodityPrice')
            //         ->where('c_name', 'like', '%' . $request->input('commodityName') . '%')
            //         ->paginate(4);
            //     return ApiController::sendApiResponse($query, 200, [], 'Search success!!');
            // }

            // $query = Commodity::select('c_id as CommodityId', 'c_name as CommodityName', 'c_price as CommodityPrice')
            //     ->where('c_id', $request->input('commodityId'))
            //     ->paginate(4);

            // return ApiController::sendApiResponse($query, 200, [], 'Search success!!!');
            $val = Commodity::simplePaginate(4);
            return view('commodity', ['val' => $val]);
        } catch (Throwable $th) {
            return ApiController::sendApiResponse($th->getMessage(), 500, [], 'Server error!');
        }
    }
}
