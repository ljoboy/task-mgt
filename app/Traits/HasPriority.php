<?php

namespace App\Traits;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

trait HasPriority
{
    protected static function bootHasPriority(): void
    {
        static::creating(function (Model $model) {
            if (empty($model->priotity)) {
                $model->priority = ($model->whereBelongsTo($model->project)->max('priority') ?? 0) + 1;
            }
        });
    }
}
