<?php

namespace App\Services;

use App\Models\ActivityLog;

class FileLogService
{
    public static function logExport($type, $fileName, $userId = null)
    {
        ActivityLog::log(
            'EXPORT',
            $type,
            null,
            "Exported {$type} to file: {$fileName}",
            null,
            ['file_name' => $fileName]
        );
    }

    public static function logImport($type, $fileName, $summary = [], $userId = null)
    {
        ActivityLog::log(
            'IMPORT',
            $type,
            null,
            "Imported {$type} from file: {$fileName}",
            null,
            array_merge(['file_name' => $fileName], $summary)
        );
    }

    public static function logDownload($type, $fileName, $userId = null)
    {
        ActivityLog::log(
            'DOWNLOAD',
            $type,
            null,
            "Downloaded file: {$fileName}",
            null,
            ['file_name' => $fileName]
        );
    }
}
