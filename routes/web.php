<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\CitizenController;
Route::get('/citizens', [CitizenController::class, 'index']);
Route::get('/citizens/{id}', [CitizenController::class, 'show']);
Route::post('/citizens', [CitizenController::class, 'store']);
Route::put('/citizens/{id}', [CitizenController::class, 'update']);
Route::delete('/citizens/{id}', [CitizenController::class, 'delete']);


Route::get('/', function () {
    return view('welcome');
});
