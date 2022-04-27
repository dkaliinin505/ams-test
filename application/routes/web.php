<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Stream\StreamController;
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


Route::prefix('stream')->middleware('auth')->group(function () {
    Route::get('/index',[StreamController::class,'mainPage'])->name('stream.index');
    Route::get('/create',[StreamController::class,'createStreamPage'])->name('stream.create');
    Route::post('/store',[StreamController::class,'storeStreamInfo'] );
    Route::get('/show/{stream_id}',[StreamController::class,'showStreamPage'] )->name('stream.show');
});

Auth::routes();

Route::get('/',function (){
   return view('index');
});
