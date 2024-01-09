<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\categoriesController;


/** JWT_SECRET=j8OG4dvuuagYQEMlklbMQ9CmZvGSuWHZqjtJqoAN3nONZXP3AwLxjH1h5UlOlisB
  *  API_PASSWORD=j8OG4dvuuagYQEMlklb
  */
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

/*
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
*/
    /** all routes / api here must be authenticated */
    Route::group(['middleware'=>['api','checkPassword','changeLanguage']],function(){
        /** by default in RouteServiceProvider the prefix is api ,so in postman we must
         * write URL like this
         * localhost/api-project/api/v1/get-main-categories
         * localhost:8000/api/v1/get-main-categories *
         */
        Route::post('get-main-categories',[categoriesController::class,'index']);
        Route::post('getCategoryById',[categoriesController::class,'getCategoryById']);
        Route::post('changeCategoryStatus',[categoriesController::class,'changeCategoryStatus']);

        Route::group(['prefix'=>'admin'],function(){
            Route::post('login',[AuthController::class,'login']);
            Route::post('logout',[AuthController::class,'logout'])->middleware('assignGuard:admin-api');
            //invalidate token for security side
            // broken access controller user enumeration
        });
      //  Route::post('getCategoryById2,{id}',[categoriesController::class,'getCategoryById2']);

    });

    Route::group(['middleware'=>['api','checkPassword','changeLanguage','checkAdminToken:admin-api']],function(){
        Route::post('get-main-categories',[categoriesController::class,'index']);
    });
