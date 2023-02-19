<?php

use App\Models\Project;
use App\Models\Task;
use Symfony\Component\HttpFoundation\Response;

it('can create a task', function () {
    $task = Task::factory()->for(Project::factory())->raw();
    $response = $this->postJson(route('api.v1.projects.tasks.store', $task['project_id']), $task);
    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJson(['message' => 'Task has been created'])
        ->assertJson(['success' => true]);
    $this->assertDatabaseHas('tasks', $task);
});

it('does not create a task without a name field', function () {
    $response = $this->postJson(route('api.v1.projects.tasks.store'), []);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('can fetch a task', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $response = $this->getJson(route('api.v1.projects.tasks.show', $task->id));
    $data = [
        'success' => true,
        'message' => 'Data retrieved successfully',
        'data' => $task->toArray(),
    ];

    $response->assertStatus(Response::HTTP_OK)->assertJson($data);
});

it('can not fetch a task with wrong id', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $wrongId = $task->id + 1;
    $response = $this->getJson(route('api.v1.projects.tasks.show', $wrongId));
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});

it('can update a task', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $updated = ['name' => 'Updated Name'];
    $response = $this->putJson(route('api.v1.projects.tasks.update', $task->id), $updated);
    $response->assertStatus(Response::HTTP_ACCEPTED)->assertJson(['message' => 'Task updated successfully!']);
    $this->assertDatabaseHas('tasks', $updated);
});

it('cannot update task with a wrong id', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $updated = ['name' => 'Updated Name'];
    $wrongId = $task->id + 1;
    $response = $this->putJson(route('api.v1.projects.tasks.update', $wrongId), $updated);
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});

it('cannot update task without name field', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $updated = [];
    $response = $this->putJson(route('api.v1.projects.tasks.update', $task->id), $updated);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('can delete a task', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $response = $this->deleteJson(route('api.v1.projects.tasks.destroy', $task->id));
    $response->assertStatus(Response::HTTP_NO_CONTENT);
    $this->assertCount(0, Task::all());
});

it('cannot delete a task with a wrong id', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $wrongId = $task->id + 1;
    $response = $this->deleteJson(route('api.v1.projects.tasks.destroy', $wrongId));
    $response->assertStatus(Response::HTTP_NOT_FOUND);
    $this->assertDatabaseHas('tasks', $task->toArray());
});
