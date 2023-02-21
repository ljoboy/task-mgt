<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Project\ProjectStoreRequest;
use App\Http\Requests\API\V1\Project\ProjectUpdateRequest;
use App\Http\Resources\API\V1\Project\ProjectCollection;
use App\Http\Resources\API\V1\Project\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProjectAPIController extends APIController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): mixed
    {
        $projects = Project::query()->paginate(25);

        return ProjectCollection::make($projects)->response()->getData();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectStoreRequest $request): JsonResponse
    {
        $project = Project::create($request->validated());

        return $this->responseSuccess(
            new ProjectResource($project),
            'Project has been created',
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project): JsonResponse
    {
        return $this->responseSuccess(new ProjectResource($project->load(['tasks'])));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectUpdateRequest $request, Project $project): JsonResponse
    {
        $new_project = $project->update($request->validated());

        return $new_project
            ?
            $this->responseSuccess(
                new ProjectResource($project),
                'Project updated successfully!',
                Response::HTTP_ACCEPTED
            )
            :
            $this->responseError('A problem occurred! Please try again!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project): JsonResponse
    {
        $deleted = $project->delete();

        return $deleted
            ?
            $this->responseSuccess(
                null,
                'Project deleted successfully!',
                Response::HTTP_NO_CONTENT
            )
            :
            $this->responseError('A problem occurred! Please try again!');
    }
}
