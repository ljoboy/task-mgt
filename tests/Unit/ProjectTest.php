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
