<?php
namespace App\Traits;

use App\Services\ActivityLogger;

trait LogsActivity
{
    protected static function bootLogsActivity(): void
    {
        foreach (['created', 'updated', 'deleted'] as $event) {
            static::$event(function ($model) use ($event) {
                $description = ucfirst($event) . ' ' . class_basename($model);

                $data = [];
                if ($event === 'updated') {
                    $dirty = $model->getDirty();
                    $data['changes'] = collect($dirty)->map(function ($value, $key) use ($model) {
                        return [
                            'field' => $key,
                            'old' => $model->getOriginal($key),
                            'new' => $value
                        ];
                    })->values()->toArray();
                }

                ActivityLogger::log(
                    action: $event,
                    description: $description,
                    model: $model,
                    data: $data
                );
            });
        }
    }
}
