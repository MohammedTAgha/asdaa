<?php

namespace App\Traits;

use App\Services\FileLogService;

trait LogsExports
{
    public function logExport($type = null)
    {
        $fileName = $this->getFileName() ?? class_basename($this);
        FileLogService::logExport(
            $type ?? class_basename($this),
            $fileName,
            auth()->id()
        );
    }

    protected function getFileName()
    {
        return property_exists($this, 'fileName') ? $this->fileName : null;
    }
}
