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
    'prefix'=>'admin',
    'middleware'=>['api','checkPassword'],
    'namespace'=>'App\Http\Controllers\Admin'
],function(){
    Route::post('/login','AdminAuthController@login')->name('admin.login');
});

Route::group([
    'prefix'=>'admin',
    'middleware'=>['api','checkPassword','checkAdminToken:admin-api'],
    'namespace'=>'App\Http\Controllers\Admin'
],function(){
    Route::post('/logout','AdminAuthController@logout')->name('admin.logout');
});
########################### End Admin API ##########################