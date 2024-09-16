<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RegionRepresentativeController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\DistributionCategoryController;
use App\Http\Controllers\DistributionCitizenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\CitizenUploadController;
use App\Imports\CitizenDistributionImport;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// File routes
Route::prefix('files')->group(function () {
    Route::get('/', [FileController::class, 'index'])->name('files.index');
    Route::post('/upload', [FileController::class, 'upload'])->name('files.upload');
    Route::get('/{file}', [FileController::class, 'show'])->name('files.show');
});

// Public distribution routes
Route::get('/distributions/{id}/export', [DistributionController::class, 'export'])->name('distributions.export');
Route::get('/get-distributions', [DistributionController::class, 'getDistributions'])->name('getDistributions');
Route::resource('distribution_citizens', DistributionCitizenController::class)->except(['create', 'edit']);
Route::post('/distributions/add-citizens', [DistributionController::class, 'addCitizens'])->name('distributions.addCitizens');
Route::post('/distributions/add-citizens-filter', [DistributionController::class, 'addCitizensFilter'])->name('distributions.addCitizensFilter');
Route::delete('/distributions/pivot/{id}', [DistributionController::class, 'removeCitizenFromDistribution'])->name('distributions.removeCitizen');
Route::post('/update-pivot', [DistributionController::class, 'updatePivot'])->name('update.pivot');
Route::get('/projects-report-export', [DistributionController::class, 'exportDistributionStatistics'])->name('distributions.exportDistributionStatistics');
Route::get('/projects-reports', [ReportController::class, 'showStatistics'])->name('reports.showStatistics');

// Citizen Upload routes
Route::get('/upload-citizens', [CitizenUploadController::class, 'showUploadForm'])->name('upload.citizens.form');
Route::post('/upload-citizens', [CitizenUploadController::class, 'uploadCitizens'])->name('upload.citizens');
Route::get('/report/export', [CitizenUploadController::class, 'exportReport'])->name('report.export');

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Super Manager routes
    Route::middleware(['role:Super Manager'])->group(function () {
        Route::prefix('citizens')->group(function () {
            Route::post('/remove', [CitizenController::class, 'removeSelectedCitizens'])->name('citizens.remove');
            Route::post('/change-region', [CitizenController::class, 'changeRegionForSelectedCitizens'])->name('citizens.change-region');
            Route::get('/import', [CitizenController::class, 'import'])->name('citizens.import');
            Route::get('/export', [CitizenController::class, 'export'])->name('citizens.export');
            Route::post('/upload', [CitizenController::class, 'upload'])->name('citizens.upload');
            Route::get('/template', [CitizenController::class, 'downloadTemplate'])->name('citizens.template');
            Route::post('/{id}/restore', [CitizenController::class, 'restore'])->name('citizens.restore');
            Route::post('/restore-multiple', [CitizenController::class, 'restoreMultiple'])->name('citizens.restore-multiple');
        });

        Route::resource('distributions', DistributionController::class);
        Route::resource('distribution_categories', DistributionCategoryController::class);
        Route::resource('children', ChildController::class);
        Route::resource('representatives', RegionRepresentativeController::class);
        Route::resource('regions', RegionController::class);
        Route::resource('users', UserController::class);
        Route::resource('committees', CommitteeController::class);
        Route::get('/test', [HomeController::class, 'test'])->name('test');
    });

    // Admin routes
    Route::middleware(['role:Admin,Super Manager'])->group(function () {
        // All routes from Super Manager, except user-related actions
        Route::resource('citizens', CitizenController::class);
        Route::resource('distributions', DistributionController::class)->except(['destroy']);
        Route::resource('staff', StaffController::class)->except(['destroy']);
    });

    // Region Manager routes
    Route::middleware(['role:Region Manager,Admin,Super Manager'])->group(function () {
        Route::prefix('citizens')->group(function () {
            Route::get('/', [CitizenController::class, 'index'])->name('citizens.index');
            Route::get('/data', [CitizenController::class, 'getData'])->name('citizens.data');
        });

        Route::get('/', [HomeController::class, 'index'])->name('home');
    
        Route::resource('citizens', CitizenController::class)->except(['create', 'edit']);;
        Route::resource('sources', SourceController::class)->except(['create', 'edit']);
        Route::resource('staff', StaffController::class)->only(['index', 'show']);
    });

    // Guest routes
    Route::middleware(['role:Guest'])->group(function () {
        // Guest routes can be added here...
    });
});

// Logout route
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('home');
})->name('logout');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';





// Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/test', [HomeController::class, 'test'])->name('test'); 

// Route::resource('regions', RegionController::class);
// Route::resource('representatives', RegionRepresentativeController ::class);
// Route::get('/citizens/import', [CitizenController::class, 'import'])->name('citizens.import');
// Route::get('/citizens/export', [CitizenController::class, 'export'])->name('citizens.export');
// Route::post('/citizens/upload', [CitizenController::class, 'upload'])->name('citizens.upload');
// Route::get('/citizens/template', [CitizenController::class, 'downloadTemplate'])->name('citizens.template');
// Route::resource('citizens', CitizenController::class);
// Route::resource('distributions', DistributionController::class);
// Route::resource('distribution_categories', DistributionCategoryController::class);
// Route::resource('children', ChildController::class);


// Route::resource('distribution_citizens', DistributionCitizenController::class);
// Route::post('/distributions/add-citizens', [DistributionController::class, 'addCitizens'])->name('distributions.addCitizens');
// Route::get('/get-distributions', [DistributionController::class, 'getDistributions'])->name('getDistributions');
// Route::delete('/distributions/pivot/{id}', [DistributionController::class, 'removeCitizenFromDistribution'])->name('distributions.removeCitizen');
// Route::post('/update-pivot', [DistributionController::class, 'updatePivot'])->name('update.pivot');// Route::get('/citizens', [CitizenController::class, 'index']);

// Route::get('/upload-citizens', [CitizenUploadController::class, 'showUploadForm'])->name('upload.citizens.form');
// Route::post('/upload-citizens', [CitizenUploadController::class, 'uploadCitizens'])->name('upload.citizens');
