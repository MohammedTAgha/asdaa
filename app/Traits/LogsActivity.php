<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            ActivityLog::log(
                'CREATE',
                get_class($model),
                $model->id,
                "Created new " . class_basename($model),
                null,
                $model->toArray()
            );
        });

        static::updated(function ($model) {
            $oldValues = array_intersect_key($model->getOriginal(), $model->getDirty());
            $newValues = $model->getDirty();
            
            ActivityLog::log(
                'UPDATE',
                get_class($model),
                $model->id,
                "Updated " . class_basename($model),
                $oldValues,
                $newValues
            );
        });

        static::deleted(function ($model) {
            ActivityLog::log(
                'DELETE',
                get_class($model),
                $model->id,
                "Deleted " . class_basename($model),
                $model->toArray(),
                null
            );
        });
    }
}
