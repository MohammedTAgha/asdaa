<?php

namespace App\Models\Traits;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

trait Loggable
{
    protected static function bootLoggable()
    {
        static::created(function ($model) {
            $model->logActivity('created');
        });

        static::updated(function ($model) {
            $model->logActivity('updated');
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted');
        });
    }

    public function logActivity($action, $details = null)
    {
        $oldValues = $action === 'updated' ? $this->getOriginal() : null;
        $newValues = $action === 'deleted' ? null : $this->getAttributes();

        Log::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => get_class($this),
            'model_id' => $this->getKey(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'details' => $details
        ]);
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'model');
    }
} 