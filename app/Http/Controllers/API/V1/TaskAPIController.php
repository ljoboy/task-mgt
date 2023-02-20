<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Task\StoreTaskRequest;
use App\Http\Requests\API\V1\Task\UpdateTaskRequest;
use App\Http\Resources\API\V1\Project\ProjectResource;
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
    public function index(): JsonResponse
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request, Project $project): JsonResponse
    {
        $task = $project->tasks()->create($request->validated());

        return $this->responseSuccess(
            new TaskResource($task),
            'Task has been created',
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Task $task): JsonResponse
    {
        return $this->responseSuccess(new TaskResource($task));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Project $project,Task $task): JsonResponse
    {
        $new_task = $task->update($request->validated());

        return $new_task
            ?
            $this->responseSuccess(
                new TaskResource($project),
                'Task updated successfully!',
                Response::HTTP_ACCEPTED
            )
            :
            $this->responseError('A problem occurred! Please try again!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Task $task): JsonResponse
    {
        $deleted = $task->delete();

        return $deleted
            ?
            $this->responseSuccess(
                null,
                'Task deleted successfully!',
                Response::HTTP_NO_CONTENT
            )
            :
            $this->responseError('A problem occurred! Please try again!');
    }
}
