<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Task\StoreTaskRequest;
use App\Http\Requests\API\V1\Task\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Response;

class TaskAPIController extends APIController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): Response
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): Response
    {
        //
    }
}
