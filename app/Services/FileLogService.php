<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class FileLogService
{
    public function logFileDownload($file, $type = 'export')
    {
        Log::create([
            'user_id' => Auth::id(),
            'action' => 'file_download',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'details' => [
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'download_type' => $type
            ]
        ]);
    }

    public function logFileImport($file, $importType, $recordCount = null)
    {
        Log::create([
            'user_id' => Auth::id(),
            'action' => 'file_import',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'details' => [
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'import_type' => $importType,
                'records_imported' => $recordCount
            ]
        ]);
    }
} 