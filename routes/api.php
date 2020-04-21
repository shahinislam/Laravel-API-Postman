<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
Route::get('country', 'CountryControllergg@country');
Route::get('country/{id}', 'CountryControllergg@countryByID');
Route::post('country', 'CountryControllergg@countrySave');
Route::put('country/{id}', 'CountryControllergg@countryUpdate');
Route::delete('country/{id}', 'CountryControllergg@countryDelete');
*/


Route::apiResource('country', 'CountryController')->middleware('client');

Route::get('download', 'PhotoController@download');
Route::post('upload', 'PhotoController@upload');


