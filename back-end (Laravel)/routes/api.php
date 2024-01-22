<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\LoginController;

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


Route::get('/',function(){
    return response()->json(['message' => 'ok']);
});
Route::group(['prefix' => 'v1'],function(){
    Route::group(['middleware' => 'auth:api'],function () {
        Route::group(['prefix' => 'task'],function(){
            Route::get('/', [TaskController::class, 'index'])->name('task.index');
            Route::post('/', [TaskController::class, 'store'])->name('task.store');
            Route::get('/{id}', [TaskController::class, 'show'])->name('task.show');
            Route::put('/{id}', [TaskController::class, 'update'])->name('task.update');
            Route::delete('/{id}', [TaskController::class, 'destroy'])->name('task.destroy');
        });
        Route::get('/me',[LoginController::class,'me']);
        Route::get('auth/logout',[LoginController::class,'logout']);
    });
    Route::group(['prefix' => 'auth'],function(){
        Route::post('/',[LoginController::class,'index']);
    });

});
