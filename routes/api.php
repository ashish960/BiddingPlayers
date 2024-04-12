<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Biddingcontroller;
use App\Http\Controllers\Api\BiddingStartController;
use Illuminate\Support\Facades\Validator; 
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();



});

//admin routes
Route::post('Admin/login',[Biddingcontroller::class,'AdminLogin']);


Route::middleware(['auth:api','scope:Admin'])->group(function(){
    Route::post('Admin/SetGame',[Biddingcontroller::class,'SetGame']);
    Route::post('Admin/AddTeam',[Biddingcontroller::class,'AddTeam']);
    Route::post('Admin/AddPlayer',[Biddingcontroller::class,'AddPlayer']);
    Route::post('Admin/AllotTeam',[Biddingcontroller::class,'SelectTeam']);
    Route::post('Admin/Start/Bid',[Biddingcontroller::class,'startBid']);
   });


 
//Team Routes


//login team
 Route::post('Team/login',[Biddingcontroller::class,'TeamLogin']);

    Route::middleware(['auth:api','scopes:Admin'])->group(function(){
    Route::post('Active/Player/View',[Biddingcontroller::class,'ActivePlayerView']);
    Route::post('Player/Bid',[Biddingcontroller::class,'SetPlayerBid']);
});





