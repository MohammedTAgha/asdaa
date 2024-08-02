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
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RegionRepresentativeController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\DistributionCategoryController;
use App\Http\Controllers\DistributionCitizenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChildController;
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/test', [HomeController::class, 'test'])->name('test');

Route::resource('regions', RegionController::class);
Route::resource('representatives', RegionRepresentativeController::class);
Route::get('/citizens/import', [CitizenController::class, 'import'])->name('citizens.import');
Route::get('/citizens/export', [CitizenController::class, 'export'])->name('citizens.export');
Route::post('/citizens/upload', [CitizenController::class, 'upload'])->name('citizens.upload');
Route::get('/citizens/template', [CitizenController::class, 'downloadTemplate'])->name('citizens.template');
Route::resource('citizens', CitizenController::class);
Route::resource('distributions', DistributionController::class);
Route::resource('distribution_categories', DistributionCategoryController::class);
Route::resource('children', ChildController::class);


Route::resource('distribution_citizens', DistributionCitizenController::class);
Route::post('/distributions/add-citizens', [DistributionController::class, 'addCitizens'])->name('distributions.addCitizens');
Route::get('/get-distributions', [DistributionController::class, 'getDistributions'])->name('getDistributions');
Route::delete('/distributions/pivot/{id}', [DistributionController::class, 'removeCitizenFromDistribution'])->name('distributions.removeCitizen');
Route::post('/update-pivot', [DistributionController::class, 'updatePivot'])->name('update.pivot');// Route::get('/citizens', [CitizenController::class, 'index']);
// Route::get('/citizens/{id}', [CitizenController::class, 'show']);
// Route::post('/citizens', [CitizenController::class, 'store']);
// Route::put('/citizens/{id}', [CitizenController::class, 'update']);
// Route::delete('/citizens/{id}', [CitizenController::class, 'delete']);

// Route::get('/regions', [RegionController::class, 'index']);
// Route::get('/regions/{id}', [RegionController::class, 'show']);
// Route::post('/regions', [RegionController::class, 'store']);
// Route::put('/regions/{id}', [RegionController::class, 'update']);
// Route::delete('/regions/{id}', [RegionController::class, 'delete']);

Route::get('/logout', function () {
    // Implement logout functionality
    return redirect()->route('home');
})->name('logout');