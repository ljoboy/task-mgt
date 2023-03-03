<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Task\ReorderRequest;
use App\Http\Requests\API\V1\Task\StoreTaskRequest;
use App\Http\Requests\API\V1\Task\UpdateTaskRequest;
use App\Http\Resources\API\V1\Task\TaskCollection;
use App\Http\Resources\API\V1\Task\TaskResource;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskAPIController extends APIController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project = null): JsonResponse
    {
        $tasks = $project?->tasks() ?? Task::query()->orderBy('project_id', 'ASC');

        return $this->responseSuccess(
            data: TaskCollection::make($tasks->get()),
            message: 'Tasks retrieved successfully',
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request, Project $project): JsonResponse
    {
        $task = $project->tasks()->create($request->validated());

        return $this->responseSuccess(
            data: new TaskResource($task),
            message: 'Task has been created',
            code: Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Task $task): JsonResponse
    {
        $this->taskProjectValidation($project, $task);

        return $this->responseSuccess(
            data: new TaskResource($task),
            message: 'Task retrieved successfully',
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task): JsonResponse
    {
        $this->taskProjectValidation($project, $task);
        $new_task = $task->update($request->validated());
        return $new_task
            ?
            $this->responseSuccess(
                data: new TaskResource($task),
                message: 'Task updated successfully!',
                code: Response::HTTP_ACCEPTED
            )
            :
            $this->responseError();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Task $task): JsonResponse
    {
        $this->taskProjectValidation($project, $task);
        $deleted = $task->delete();

        return $deleted
            ?
            $this->responseSuccess(
                data: null,
                message: 'Task deleted successfully!',
                code: Response::HTTP_NO_CONTENT
            )
            :
            $this->responseError();
    }

    public function reorder(ReorderRequest $request, Project $project, Task $task)
    {
        $this->taskProjectValidation($project, $task);
        $new_priority = $request->get('new_priority');

        $task->reorder($new_priority);

        return $this->responseSuccess(
            data: new TaskCollection($project->tasks),
            message: 'Tasks reorder successfully!',
            code: Response::HTTP_ACCEPTED
        );
    }

    private function taskProjectValidation(Project $project, Task $task): void
    {
            $task->whereProjectId($project->id)->exists() ?? $this->responseError();
    }
}
