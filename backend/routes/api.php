<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Area;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// area一覧
Route::get('/areas', function () {
    return Area::all();
});
// areaの絞り込み
Route::post('/areas/', function ($id, Request $request) {
    return '';
    // return Area::search_area($request);
});

// 特定IDのAreaを返す
Route::get('/area/{id}', function ($id) {
    return Area::where('id', $id)->get();
});

// ログインしていないといけない系
// areaを編集して更新するメソッド
Route::post('/area/{id}', function ($id, Request $request) {
    // dd($id);
    // dd($request->all()[0]);
    $request = $request->all()[0];
    // return 'post_id' . $id;
    $area = Area::editArea($id, $request);
    // var_dump($area->toArray());
    return $area;
});
