<?php

use Illuminate\Http\Request;

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

Route::namespace('API')->group(function () {
    
    Route::post('/login', 'UserController@login');
    Route::get('/logout', 'UserController@logout');
    
    Route::group(['middleware' => ['jwt.verify']], function() {        
        Route::prefix('/users')->group(function(){
            Route::get('/',         'UserController@index');
            Route::get('/{id}',     'UserController@show');

            Route::post('/save',    'UserController@save');
            Route::put('/update/{id}',  'UserController@update');   

            Route::delete('/delete/{id}',  'UserController@dalete');        
        });
    });
});
