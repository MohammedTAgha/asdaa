<?php

namespace App\Traits;

use App\Services\FileLogService;
use Illuminate\Support\Facades\Log;

trait LogsExports
{
    public function logExport($type = null)
    {
        Log::error('log : ' );

        try {
            $fileName = $this->getFileName() ?? class_basename($this);
            FileLogService::logExport(
                $type ?? class_basename($this),
                $fileName,
                auth()->id()
            );
        } catch(\Exception $e) {
            Log::error('eroor adding log : '.$e->getMessage());
        }
    }

    protected function getFileName()
    {
        return property_exists($this, 'fileName') ? $this->fileName : null;
    }
}
