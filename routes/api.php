<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\LoginSystemController;
use App\Http\Controllers\api\ProductCategoryController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('signup', [LoginSystemController::class, 'signup']);
Route::post('signin', [LoginSystemController::class, 'signin']);

Route::middleware('auth:api')->group(function(){
    Route::get('signin_check', [LoginSystemController::class, 'signin_check']);
    Route::get('signout_confirm', [LoginSystemController::class, 'signout_confirm']);
    Route::prefix('product_category')->group(function(){
        Route::post('create', [ProductCategoryController::class, 'create']);
        Route::get('single/{pc_id}', [ProductCategoryController::class, 'single_category']);
        Route::post('update/{pc_id}', [ProductCategoryController::class, 'update']);
        Route::get('destroy/{pc_id}', [ProductCategoryController::class, 'destroy']);
        Route::get('list', [ProductCategoryController::class, 'list']);
    });
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
