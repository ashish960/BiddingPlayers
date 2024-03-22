<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Biddingcontroller;
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


//Routes for admin access.


//first cmd by admin
Route::post('Admin/{id}/{name}/{task}',[Biddingcontroller::class,'Adminlogin'])->middleware('guard');
//to add player
Route::post('Admin/addplayer',[Biddingcontroller::class,'AddPlayer']);
//to add team
Route::post('Admin/addteam',[Biddingcontroller::class,'AddTeam'])->name('add.team');

//to display no-access
Route::get('/no-access',function(){
    echo "you cannot access this page";
});


//login team
Route::get('login/team/{id}',[Biddingcontroller::class,'playerview']);

//player bidding
Route::post('login/team/{id}',[BIddingcontroller::class,'setplayerbid']);
