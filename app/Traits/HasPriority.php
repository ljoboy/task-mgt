<?php

declare(strict_types=1);

namespace App\Traits;

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
