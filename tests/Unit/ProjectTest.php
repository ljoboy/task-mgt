<?php

use App\Models\Project;
use Symfony\Component\HttpFoundation\Response;

it('can create a project', function () {
    $project = Project::factory()->raw();
    $response = $this->postJson('/api/v1/projects', $project);
    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJson(['message' => 'Project has been created'])
        ->assertJson(['success' => true]);
    $this->assertDatabaseHas('projects', $project);
});

it('does not create a project without a name field', function () {
    $response = $this->postJson('/api/v1/projects', []);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('can fetch a project', function () {
    $project = Project::factory()->create();
    $response = $this->getJson(route('api.v1.projects.show', $project->id));
    $data = [
        'success' => true,
        'message' => 'Data retrieved successfully',
        'data' => $project->toArray(),
    ];

    $response->assertStatus(Response::HTTP_OK)->assertJson($data);
});

it('can not fetch a project with wrong id', function () {
    $project = Project::factory()->create();
    $wrongId = $project->id + 1;
    $response = $this->getJson(route('api.v1.projects.show', $wrongId));
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});
