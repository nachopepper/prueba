<?php

use App\Http\Controllers\DolarController;
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

Route::get('/getDolar', [DolarController::class, 'show']);
Route::get('/downloadExcel', [DolarController::class, 'downloadExcel']);



