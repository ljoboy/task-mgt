<?php

declare(strict_types=1);

use App\Http\Resources\API\V1\Project\ProjectResource;
use App\Models\Project;
use Symfony\Component\HttpFoundation\Response;

it('can create a project', function () {
    $project = Project::factory()->raw();
    $response = $this->postJson(route('api.v1.projects.store'), $project);
    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJson(['message' => 'Project has been created'])
        ->assertJson(['success' => true]);
    $this->assertDatabaseHas('projects', $project);
});

it('does not create a project without a name field', function () {
    $response = $this->postJson(route('api.v1.projects.store'), []);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('can fetch a project', function () {
    $project = Project::factory()->create();
    $response = $this->getJson(route('api.v1.projects.show', $project->id));
    $data = [
        'success' => true,
        'message' => 'Data retrieved successfully',
        'data' => (new ProjectResource($project))->jsonSerialize(),
    ];

    $response->assertStatus(Response::HTTP_OK)->assertJson($data);
});

it('can not fetch a project with wrong id', function () {
    $project = Project::factory()->create();
    $wrongId = $project->id + 1;
    $response = $this->getJson(route('api.v1.projects.show', $wrongId));
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});

it('can update a project', function () {
    $project = Project::factory()->create();
    $updated = ['name' => 'Updated Name'];
    $response = $this->putJson(route('api.v1.projects.update', $project->id), $updated);
    $response->assertStatus(Response::HTTP_ACCEPTED)->assertJson(['message' => 'Project updated successfully!']);
    $this->assertDatabaseHas('projects', $updated);
});

it('cannot update project with a wrong id', function () {
    $project = Project::factory()->create();
    $updated = ['name' => 'Updated Name'];
    $wrongId = $project->id + 1;
    $response = $this->putJson(route('api.v1.projects.update', $wrongId), $updated);
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});

it('cannot update project without name field', function () {
    $project = Project::factory()->create();
    $updated = [];
    $response = $this->putJson(route('api.v1.projects.update', $project->id), $updated);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('can delete a project', function () {
    $project = Project::factory()->create();
    $response = $this->deleteJson(route('api.v1.projects.destroy', $project->id));
    $response->assertStatus(Response::HTTP_NO_CONTENT);
    $this->assertCount(0, Project::all());
});

it('cannot delete a project with a wrong id', function () {
    $project = Project::factory()->create();
    $wrongId = $project->id + 1;
    $response = $this->deleteJson(route('api.v1.projects.destroy', $wrongId));
    $response->assertStatus(Response::HTTP_NOT_FOUND);
    $this->assertDatabaseHas('projects', $project->toArray());
});
