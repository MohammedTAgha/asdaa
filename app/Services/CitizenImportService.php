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
     * @return array
     */
    public function import(UploadedFile $file, ?int $regionId = null): array
    {
        $import = new CitizensImport($regionId);
        $initialCount = Citizen::count();
        
        try {
            Excel::import($import, $file);
            $finalCount = Citizen::count();
            $addedCount = $finalCount - $initialCount;
            
            return $this->handleSuccessfulImport($import, $addedCount, $regionId);
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