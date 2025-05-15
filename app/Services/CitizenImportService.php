<?php

namespace App\Services;

use App\Exports\FailedRowsExport;
use App\Imports\CitizensImport;
use App\Models\Citizen;
use App\Models\Region;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class CitizenImportService
{
    /**
     * Handle the import of citizens from an Excel file
     *
     * @param UploadedFile $file
     * @param int|null $regionId
     * @param bool $shouldUpdateExisting
     * @return array
     */
    public function import(UploadedFile $file, ?int $regionId = null, bool $shouldUpdateExisting = false): array
    {
        $import = new CitizensImport($regionId, $shouldUpdateExisting);
        $initialCount = Citizen::count();
        
        try {
            Excel::import($import, $file);
            $finalCount = Citizen::count();
            $addedCount = $finalCount - $initialCount;
            
            return $this->generateDetailedReport($import, $addedCount, $regionId);
        } catch (ValidationException $e) {
            Log::error('Validation error during citizen import:', [
                'errors' => $e->errors(),
                'failures' => method_exists($e, 'failures') ? $e->failures() : []
            ]);
            
            return [
                'success' => false,
                'errors' => $e->errors(),
                'failedRows' => method_exists($e, 'failures') ? $e->failures() : []
            ];
        } catch (\Exception $e) {
            Log::error('Error during citizen import:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'An error occurred during import: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Generate a detailed report of the import process
     *
     * @param CitizensImport $import
     * @param int $addedCount
     * @param int|null $regionId
     * @return array
     */
    private function generateDetailedReport(CitizensImport $import, int $addedCount, ?int $regionId): array
    {
        $failedExcelPath = null;
        $failedRows = $import->failedRows;

        if (!empty($failedRows)) {
            $failedExcelPath = $this->generateFailedRowsReport($failedRows, $regionId);
        }

        // Get region name for display
        $regionName = 'Not specified';
        if ($regionId) {
            $region = Region::find($regionId);
            $regionName = $region ? $region->name : 'Unknown';
        }

        return [
            'success' => true,
            'summary' => [
                'total_processed' => count($import->successfulImports) + 
                                   count($import->updatedCitizens) + 
                                   count($import->skippedExisting) + 
                                   count($failedRows),
                'new_added' => count($import->successfulImports),
                'updated' => count($import->updatedCitizens),
                'skipped' => count($import->skippedExisting),
                'failed' => count($failedRows),
                'target_region' => $regionName
            ],
            'successful_imports' => $this->formatSuccessfulImports($import->successfulImports),
            'updated_citizens' => $this->formatUpdatedCitizens($import->updatedCitizens),
            'skipped_existing' => $this->formatSkippedCitizens($import->skippedExisting),
            'failed_imports' => $this->formatFailedImports($failedRows),
            'failedExcelPath' => $failedExcelPath ? Storage::url($failedExcelPath) : null,
        ];
    }

    /**
     * Format the list of successfully imported citizens
     *
     * @param array $successfulImports
     * @return array
     */
    private function formatSuccessfulImports(array $successfulImports): array
    {
        return array_map(function ($import) {
            return [
                'id' => $import['id'],
                'name' => $import['name'],
                'region' => Region::find($import['region_id'])?->name ?? 'Unknown',
                'status' => 'Added successfully'
            ];
        }, $successfulImports);
    }

    /**
     * Format the list of updated citizens
     *
     * @param array $updatedCitizens
     * @return array
     */
    private function formatUpdatedCitizens(array $updatedCitizens): array
    {
        return array_map(function ($update) {
            $oldRegion = Region::find($update['old_region'])?->name ?? 'Unknown';
            $newRegion = Region::find($update['new_region'])?->name ?? 'Unknown';
            
            return [
                'id' => $update['citizen']->id,
                'name' => $update['citizen']->firstname . ' ' . $update['citizen']->lastname,
                'old_region' => $oldRegion,
                'new_region' => $newRegion,
                'status' => "Updated - Region changed from {$oldRegion} to {$newRegion}"
            ];
        }, $updatedCitizens);
    }

    /**
     * Format the list of skipped citizens
     *
     * @param array $skippedCitizens
     * @return array
     */
    private function formatSkippedCitizens(array $skippedCitizens): array
    {
        return array_map(function ($skipped) {
            return [
                'id' => $skipped['id'],
                'name' => $skipped['name'],
                'current_region' => Region::find($skipped['current_region'])?->name ?? 'Unknown',
                'status' => 'Skipped - Citizen already exists'
            ];
        }, $skippedCitizens);
    }

    /**
     * Format the list of failed imports
     *
     * @param array $failedRows
     * @return array
     */
    private function formatFailedImports(array $failedRows): array
    {
        return array_map(function ($failure) {
            return [
                'row' => $failure['row'],
                'id' => $failure['id'],
                'name' => $failure['firstname'] . ' ' . $failure['lastname'],
                'error' => $failure['errors'],
                'status' => 'Failed - ' . $failure['errors']
            ];
        }, $failedRows);
    }

    /**
     * Handle successful import and generate failed rows report if needed
     *
     * @param CitizensImport $import
     * @param int $addedCount
     * @param int|null $regionId
     * @return array
     */
    private function handleSuccessfulImport(CitizensImport $import, int $addedCount, ?int $regionId): array
    {
        $failedExcelPath = null;
        $failedRows = $import->failedRows;

        if (!empty($failedRows)) {
            $failedExcelPath = $this->generateFailedRowsReport($failedRows, $regionId);
        }

        return [
            'success' => true,
            'message' => 'Import completed successfully',
            'addedCount' => $addedCount,
            'failedCount' => count($failedRows),
            'failedRows' => $failedRows,
            'failedExcelPath' => $failedExcelPath ? Storage::url($failedExcelPath) : null,
        ];
    }

    /**
     * Generate Excel report for failed rows
     *
     * @param array $failedRows
     * @param int|null $regionId
     * @return string
     */
    private function generateFailedRowsReport(array $failedRows, ?int $regionId): string
    {
        $user = Auth::user();
        $regionMsg = $this->getRegionMessage($regionId);
        
        $fileName = sprintf(
            'failed_citizens_%s_%s_%s.xlsx',
            $user->name,
            $regionMsg,
            time()
        );

        Excel::store(new FailedRowsExport($failedRows), $fileName, 'public');
        
        return $fileName;
    }

    /**
     * Get region message for the failed rows report
     *
     * @param int|null $regionId
     * @return string
     */
    private function getRegionMessage(?int $regionId): string
    {
        if (!$regionId) {
            return 'no_region';
        }

        $region = Region::find($regionId);
        if (!$region) {
            return 'unknown_region';
        }

        try {
            if (!empty($region->representatives)) {
                return $region->representatives->first()->name;
            }
            return $region->name;
        } catch (\Throwable $th) {
            return 'region_error';
        }
    }
} 