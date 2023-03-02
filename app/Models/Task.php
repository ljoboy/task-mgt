<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasPriority;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;
    use HasPriority;

    protected $fillable = [
        'name',
        'priority',
        'project_id',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function reorder(int $new_priority)
    {

        $priorities = collect()
            ->range($this->priority, $new_priority)
            ->sort()
            ->values()
            ->toArray();

        $tasks = $this->whereProjectId($this->project_id)->whereIn('priority', $priorities);

        foreach ($tasks as $task) {
            if ($task->id === $this->id) {
                $task->update(['priority' => $new_priority]);
            } elseif ($new_priority > $this->priority) {
                $task->increment('priority');
            } else {
                $task->decrement('priority');
            }
            $task->save();
        }
    }
}
