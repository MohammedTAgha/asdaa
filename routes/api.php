<?php

use App\Models\Citizen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CitizenController;
use App\Http\Controllers\API\RegionController;
use App\Http\Controllers\API\DistributionController;
use App\Http\Controllers\Api\CitizenValidationController;


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
// Protect routes with Sanctum middleware
 // Citizens CRUD
 Route::post('/login', [AuthController::class, 'login']);
 Route::get('distributions/all', [DistributionController::class, 'all']);
 Route::get('regions/all', [RegionController::class, 'all']);
 Route::get('citizens/all', [CitizenController::class, 'all']);
 Route::apiResource('citizens', CitizenController::class);

 // Regions CRUD
 Route::apiResource('regions', RegionController::class);

 // Distributions CRUD
 Route::apiResource('distributions', DistributionController::class);

//  // Additional routes can be added here
// Route::middleware('auth:sanctum')->group(function () {
//     // Citizens CRUD
//     Route::apiResource('citizens', CitizenController::class);

//     // Regions CRUD
//     Route::apiResource('regions', RegionController::class);

//     // Distributions CRUD
//     Route::apiResource('distributions', DistributionController::class);

//     // Additional routes can be added here
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    Log::info('api');
    return $request;
});
Route::get('/',function (Request $request){
    $citizens = Citizen::all()->take(10);
    return response()->json($citizens);
});

Route::get('/testconnection',function (){
    $data = ['status'=>'connected' , 'connected'=>true];
    return response()->json($data);
});

Route::get('/citizens/{citizen}/validate', [App\Http\Controllers\Api\CitizenValidationController::class, 'validateCitizen']);