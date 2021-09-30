<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SimulatorController;
use App\Http\Controllers\PredictionController;

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




Route::get('/getStarting',[MainController::class, 'getStarting']);
Route::get('/scores',[MainController::class, 'getScores']);
Route::get('/reset-all',[MainController::class, 'resetAll']);
Route::get('/fixtures',[MainController::class, 'getFixtures']);

//predictionController
Route::get('/prediction',[PredictionController::class, 'getPrediction']);

//simulatorController

Route::get('/play-all-weeks',[SimulatorController::class, 'playAllWeeks']);
Route::get('/play-week/{weekId}',[SimulatorController::class, 'playWeekly']);
