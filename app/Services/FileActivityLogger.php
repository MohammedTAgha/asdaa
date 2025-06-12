<?php

namespace App\Services;

use App\Models\ActivityLog;

class FileActivityLogger
{
    /**
     * Log a file upload activity
     */
    public static function logUpload($fileName, $fileType, $fileSize, $path)
    {
        ActivityLog::log(
            'UPLOAD',
            'File',
            null,
            "Uploaded file: {$fileName}",
            null,
            [
                'file_name' => $fileName,
                'file_type' => $fileType,
                'file_size' => $fileSize,
                'path' => $path
            ]
        );
    }

    /**
     * Log a file download activity
     */
    public static function logDownload($fileName, $fileType)
    {
        ActivityLog::log(
            'DOWNLOAD',
            'File',
            null,
            "Downloaded file: {$fileName}",
            null,
            [
                'file_name' => $fileName,
                'file_type' => $fileType
            ]
        );
    }

    /**
     * Log an Excel import activity
     */
    public static function logImport($fileName, $modelType, $summary)
    {
        ActivityLog::log(
            'IMPORT',
            $modelType,
            null,
            "Imported data from file: {$fileName}",
            null,
            array_merge(['file_name' => $fileName], $summary)
        );
    }

    /**
     * Log an Excel export activity
     */
    public static function logExport($fileName, $modelType, $filters = [])
    {
        ActivityLog::log(
            'EXPORT',
            $modelType,
            null,
            "Exported data to file: {$fileName}",
            null,
            array_merge(['file_name' => $fileName], ['filters' => $filters])
        );
    }
}
