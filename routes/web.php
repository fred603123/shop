<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommodityController;
use App\Http\Middleware\VerifyJwt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', function () {
//     $val = 'val';
//     $abc = 'abc';
//     return view('commodity', ['val' => $val, 'abc' => $abc]);
// });

Route::get('/', function () {
    return view('login');
});

Route::get('/getCsrfToken', function () {
    return csrf_token();
});

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'addUser']);

// Route::middleware([VerifyJwt::class])->group(function () {
    Route::prefix('commodity')->group(function () {
        Route::get('/{commodityId?}', [CommodityController::class, 'getCommodity']);
    });
// });