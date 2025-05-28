<?php

use App\Http\Controllers\BigRegionController;
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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Records\PersonController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Api\CitizenValidationController;

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

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// File Management Routes (Available to all authenticated users)
Route::middleware('auth')->group(function () {
    Route::prefix('records')->group(function () {
        Route::get('/', [PersonController::class, 'index'])->name('records.home');
        Route::match(['get', 'post'], '/search', [PersonController::class, 'search'])->name('records.search');
        Route::get('/citizen/{id}', [PersonController::class, 'show'])->name('citizen.details');
        Route::get('/search-by-ids', [PersonController::class, 'showSearchByIdsForm'])->name('search.by.ids.form');
        Route::post('/search-by-ids', [PersonController::class, 'searchByIds'])->name('records.search-by-ids');
        Route::get('/search-childs', [PersonController::class, 'showChildForm'])->name('search.childs.form');
        Route::post('/search-childs', [PersonController::class, 'searchChilds'])->name('records.search-childs');
        Route::get('/search-by-id', [PersonController::class, 'searchById'])->name('records.search-by-id');

        Route::get('/search/export', [PersonController::class, 'export'])->name('search.export');
    });
 
    Route::post('/check-citizens', [CitizenController::class, 'checkCitizens'])->name('citizens.check');
    Route::post('/export-selected-citizens', [CitizenController::class, 'exportSelectedCitizens'])->name('citizens.export-selected');
    Route::post('/export-with-distributions', [CitizenController::class, 'exportSelectedWithDistributions'])->name('citizens.export-with-distributions');
    Route::post('/change-region-checked', [CitizenController::class, 'changeRegionForCheckedCitizens'])->name('citizens.change-region-checked');
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/queries', [HomeController::class, 'queries'])->name('queries');
    Route::get('/files', [FileController::class, 'index'])->name('files.index');
    Route::post('/files/upload', [FileController::class, 'upload'])->name('files.upload');
    Route::get('/files/{file}', [FileController::class, 'show'])->name('files.show');
    Route::get('/export-citizens-distributions', [CitizenController::class, 'exportWithDistributions'])->name('citizens.exportWithDistributions');
    Route::get('/distributions/{id}/export', [DistributionController::class, 'export'])->name('distributions.export');
    Route::resource('distribution_citizens', DistributionCitizenController::class);
    Route::post('/distributions/add-citizens', [DistributionController::class, 'addCitizens'])->name('distributions.addCitizens');
    Route::post('/distributions/add-citizens-filter', [DistributionController::class, 'addCitizensFilter'])->name('distributions.addCitizensFilter');
    Route::get('/get-distributions', [DistributionController::class, 'getDistributions'])->name('getDistributions');
    Route::delete('/distributions/pivot/{id}', [DistributionController::class, 'removeCitizenFromDistribution'])->name('distributions.removeCitizen');
    Route::post('/update-pivot', [DistributionController::class, 'updatePivot'])->name('update.pivot'); // Route::get('/citizens', [CitizenController::class, 'index']);

    Route::post('/distributions/{distribution}/update-citizens', [DistributionController::class, 'updateCitizens'])->name('distributions.updateCitizens');
    Route::post('/distributions/{distribution}/delete-citizens',  [DistributionController::class, 'deleteCitizens'])->name('distributions.deleteCitizens');
    Route::resource('big-regions', BigRegionController::class);
    //upload to distribution 
    Route::post('/upload-citizens', [CitizenUploadController::class, 'uploadCitizens'])->name('upload.citizens');
    Route::get('/upload-citizens', [CitizenUploadController::class, 'showUploadForm'])->name('upload.citizens.form');
    Route::get('/report/export', [CitizenUploadController::class, 'exportReport'])->name('report.export');
    Route::get('distributions/{id}/citizens', [DistributionController::class, 'getDistributionCitizens'])->name('distributions.citizens');
    Route::post('/distributions/add-all', [DistributionController::class, 'addAllCitizens'])->name('distributions.addAllCitizens');

Route::get('/family-members/test', [FamilyMemberController::class, 'test'])->name('family-members.test');
Route::get('/citizens/{citizen}/validate', [CitizenValidationController::class, 'validateCitizen'])
->name('citizens.validate');
      // Family Members Routes
      Route::get('/citizens/{citizen}/family-members/create', [FamilyMemberController::class, 'create'])->name('citizens.family-members.create');
      Route::post('/citizens/{citizen}/family-members', [FamilyMemberController::class, 'store'])->name('citizens.family-members.store');
      Route::get('/citizens/{citizen}/family-members/{member}/edit', [FamilyMemberController::class, 'edit'])->name('citizens.family-members.edit');
      Route::put('/citizens/{citizen}/family-members/{member}', [FamilyMemberController::class, 'update'])->name('citizens.family-members.update');
      Route::delete('/citizens/{citizen}/family-members/{member}', [FamilyMemberController::class, 'destroy'])->name('citizens.family-members.destroy');
      Route::get('/citizens/{citizen}/family-members/search-records', [FamilyMemberController::class, 'searchRecords'])->name('citizens.family-members.search-records');
      Route::get('/family-members/template', [FamilyMemberController::class, 'downloadTemplate'])->name('family-members.template');
      Route::get('/family-members/import', [FamilyMemberController::class, 'importForm'])->name('family-members.import-form');
      Route::post('/family-members/import', [FamilyMemberController::class, 'import'])->name('family-members.import');
      Route::post('/citizens/{citizen}/family-members/import-records', [FamilyMemberController::class, 'importRecords'])->name('citizens.family-members.import-records');
      Route::post('/citizens/{citizen}/family-members/add-children', [FamilyMemberController::class, 'addChildren'])
          ->name('citizens.family-members.add-children');
      Route::post('/family-members/automatic-assignment-with-children', 
          [FamilyMemberController::class, 'processAutomaticAssignmentWithChildren'])
          ->name('family-members.process-automatic-assignment-with-children');
    Route::get('/family-members', [FamilyMemberController::class, 'index'])->name('family-members.index');
    Route::get('/family-members/{member}', [FamilyMemberController::class, 'show'])->name('family-members.show');
    Route::get('/family-members/edit/{member}', [FamilyMemberController::class, 'edit'])->name('family-members.edit');
    // Route::get('/family-members/create', [FamilyMemberController::class, 'create'])->name('family-members.create');
    Route::get('/automatic-assignment-form', [FamilyMemberController::class, 'showAutomaticAssignmentForm'])->name('family-members.automatic-assignment-form');
    Route::post('/family-members/automatic-assignment', [FamilyMemberController::class, 'processAutomaticAssignment'])->name('family-members.process-automatic-assignment');
    Route::post('/citizens/automatic-assignment', [FamilyMemberController::class, 'processAutomaticAssignmentForCitizen'])->name('family-members.process-citizen');
    Route::get('/citizens/{citizen}/care-provider', [CitizenController::class, 'showCareProviderForm'])->name('citizens.care-provider');
    Route::put('/citizens/{citizen}/care-provider', [CitizenController::class, 'updateCareProvider'])->name('citizens.update-care-provider');
});

// Route::get('/citizens/data', [CitizenController::class, 'getData'])->name('citizens.data');


Route::middleware(['auth'])->group(function () {
    // Super Manager routes

    Route::middleware(['role:Super Manager'])->group(function () {
        Route::get('/citizens/create', [CitizenController::class, 'create'])->name('citizens.create');
        Route::prefix('citizens')->group(function () {
            Route::post('/remove', [CitizenController::class, 'removeSelectedCitizens'])->name('citizens.remove');
            Route::post('/change-region', [CitizenController::class, 'changeRegionForSelectedCitizens'])->name('citizens.change-region');
            Route::get('/import', [CitizenController::class, 'import'])->name('citizens.import');
            Route::get('/export', [CitizenController::class, 'export'])->name('citizens.export');
            Route::post('/upload', [CitizenController::class, 'upload'])->name('citizens.upload');
            Route::get('/template', [CitizenController::class, 'downloadTemplate'])->name('citizens.template');
            Route::get('/data', [CitizenController::class, 'getData'])->name('citizens.data');
            Route::post('/{id}/restore', [CitizenController::class, 'restore'])->name('citizens.restore');
            Route::post('/restore-multiple', [CitizenController::class, 'restoreMultiple'])->name('citizens.restore-multiple');
            Route::get('/export-import-report', [CitizenController::class, 'exportImportReport'])
                ->name('citizens.export-import-report');
        });
        Route::get('/actions', [HomeController::class, 'actions'])->name('actions');
        Route::get('/test', [HomeController::class, 'test'])->name('test');
        Route::resource('citizens', CitizenController::class);
        Route::resource('distributions', DistributionController::class);
        Route::resource('distribution_categories', DistributionCategoryController::class);
        Route::resource('children', ChildController::class);
        Route::resource('representatives', RegionRepresentativeController::class);
        Route::resource('regions', RegionController::class);

        // only for super admins

        Route::resource('users', UserController::class);
        Route::resource('committees', CommitteeController::class);

        Route::get('/projects-report-export', [DistributionController::class, 'exportDistributionStatistics'])->name('distributions.exportDistributionStatistics'); // Route::get('/citizens', [CitizenController::class, 'index']);
        Route::get('/projects-reports', [ReportController::class, 'showStatistics'])->name('reports.showStatistics'); // Route::get('/citizens', [CitizenController::class, 'index']);

    });

    // Admin routes
    Route::middleware(['role:Admin,Super Manager'])->group(function () {

        Route::prefix('citizens')->group(function () {
            Route::post('/remove', [CitizenController::class, 'removeSelectedCitizens'])->name('citizens.remove');
            Route::post('/change-region', [CitizenController::class, 'changeRegionForSelectedCitizens'])->name('citizens.change-region');
            Route::get('/import', [CitizenController::class, 'import'])->name('citizens.import');
            Route::get('/export', [CitizenController::class, 'export'])->name('citizens.export');
            Route::post('/upload', [CitizenController::class, 'upload'])->name('citizens.upload');
            Route::get('/template', [CitizenController::class, 'downloadTemplate'])->name('citizens.template');
            Route::get('/data', [CitizenController::class, 'getData'])->name('citizens.data');
            Route::post('/{id}/restore', [CitizenController::class, 'restore'])->name('citizens.restore');
            Route::post('/restore-multiple', [CitizenController::class, 'restoreMultiple'])->name('citizens.restore-multiple');
            Route::get('/export-import-report', [CitizenController::class, 'exportImportReport'])
                ->name('citizens.export-import-report');
        });
        Route::get('/test', [HomeController::class, 'test'])->name('test');
        Route::resource('citizens', CitizenController::class);
        Route::resource('distributions', DistributionController::class);
        Route::resource('distribution_categories', DistributionCategoryController::class);
        Route::resource('children', ChildController::class);
        Route::resource('representatives', RegionRepresentativeController::class);
        Route::resource('regions', RegionController::class);


        // Additional routes for Admin and Super Manager...
    });

    // Region Manager routes
    Route::middleware(['role:Region Manager,Admin,Super Manager'])->group(function () {


        Route::prefix('citizens')->group(function () {

            Route::get('/data', [CitizenController::class, 'getData'])->name('citizens.data');
        });
        // Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::resource('staff', StaffController::class);
        // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        // Route::get('/files', [FileController::class, 'index'])->name('files.index');
        // Route::post('/files/upload', [FileController::class, 'upload'])->name('files.upload');
        // Route::get('/files/{file}', [FileController::class, 'show'])->name('files.show');
        // Route::get('/citizens/data', [CitizenController::class, 'getData'])->name('citizens.data');
        // Route::resource('regions', RegionController::class);
        // Route::resource('representatives', RegionRepresentativeController::class);
        // Route::get('/citizens/import', [CitizenController::class, 'import'])->name('citizens.import');
        // Route::get('/citizens/export', [CitizenController::class, 'export'])->name('citizens.export');
        // Route::post('/citizens/upload', [CitizenController::class, 'upload'])->name('citizens.upload');
        // Route::get('/citizens/template', [CitizenController::class, 'downloadTemplate'])->name('citizens.template');
        // Route::resource('citizens', CitizenController::class);
        // Route::resource('distributions', DistributionController::class);
        // Route::resource('distribution_categories', DistributionCategoryController::class);
        // Route::resource('children', ChildController::class);
    });


    // Guest routes
    Route::middleware(['role:Guest'])->group(function () {});

  
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

Route::get('/test', function () {
    dd('test');
    return view('dashboard');
});

Route::resource('categories', CategoryController::class);
Route::post('/categories/{category}/add-members', [CategoryController::class, 'addMembers'])->name('categories.add-members');
Route::get('/categories/{category}/export', [CategoryController::class, 'export'])->name('categories.export');
Route::get('/categories/{category}/import', [CategoryController::class, 'importForm'])->name('categories.import-form');
Route::post('/categories/{category}/import', [CategoryController::class, 'import'])->name('categories.import');
Route::get('/categories/template', [CategoryController::class, 'downloadTemplate'])->name('categories.template');


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
