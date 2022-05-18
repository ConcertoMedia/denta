<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('/admins','App\Http\Controllers\AdminController');

Route::apiResource('/cities','App\Http\Controllers\CityController');

Route::apiResource('/suppliers','App\Http\Controllers\SupplierController');

Route::apiResource('/categories','App\Http\Controllers\CategoryController');

########################### Begin Admin API ########################
Route::group([

    'middleware' => 'api',
    'prefix' => 'admin',
    'namespace' => '/Admin'

], function ($router) {

    Route::post('login', 'AdminAuthController@login');
    Route::post('logout', 'AdminAuthController@logout');
    Route::post('refresh', 'AdminAuthController@refresh');
    Route::post('me', 'AdminAuthController@me');

});
########################### End Admin API #########################