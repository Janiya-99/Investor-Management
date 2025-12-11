<?php

namespace App\Traits;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

trait Loggable
{
    use LogsActivity;

    /**
     * Configure activity log options
     */
    public function getActivitylogOptions(): LogOptions
    {
        $fillable = $this->getFillable();
        
        // Exclude sensitive fields from logging
        $sensitiveFields = ['password', 'remember_token', 'otp'];
        $loggableFields = array_diff($fillable, $sensitiveFields);
        
        return LogOptions::defaults()
            ->logOnly($loggableFields)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => $this->getDescriptionForEvent($eventName))
            ->useLogName('system');
    }

    /**
     * Get description for activity log event
     */
    protected function getDescriptionForEvent(string $eventName): string
    {
        $modelName = class_basename($this);
        
        return match($eventName) {
            'created' => "Created {$modelName}",
            'updated' => "Updated {$modelName}",
            'deleted' => "Deleted {$modelName}",
            default => "Performed action on {$modelName}",
        };
    }
}
