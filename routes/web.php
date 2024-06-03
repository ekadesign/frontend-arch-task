<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', function (){
    return 'api is here';
});
Route::resource('couriers', \App\Http\Controllers\CourierController::class);
Route::resource('regions', \App\Http\Controllers\RegionController::class);
Route::resource('leftlist', \App\Http\Controllers\LeftListController::class);
