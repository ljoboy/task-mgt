<?php

declare(strict_types=1);

use App\Http\Resources\API\V1\Task\TaskResource;
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

it('cannot create a task with a wrong project id', function () {
    $task = Task::factory()->for(Project::factory())->raw();
    $wrongId = $task['project_id'] + 1;
    $response = $this->postJson(route('api.v1.projects.tasks.store', $wrongId), $task);
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});

it('cannot create a task without a name field', function () {
    $project = Project::factory()->create();
    $response = $this->postJson(route('api.v1.projects.tasks.store', $project), []);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('can fetch a task', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $response = $this->getJson(route('api.v1.projects.tasks.show', [$task->project, $task]));
    $data = [
        'success' => true,
        'message' => 'Task retrieved successfully',
        'data' => (new TaskResource($task))->jsonSerialize(),
    ];

    $response->assertStatus(Response::HTTP_OK)->assertJson($data);
});

it('can not fetch a task with wrong id', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $wrongId = $task->id + 1;
    $response = $this->getJson(route('api.v1.projects.tasks.show', [$task->project, $wrongId]));
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});

it('can not fetch a task with a wrong project id', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $wrongId = $task->project->id + 1;
    $response = $this->getJson(route('api.v1.projects.tasks.show', [$wrongId, $task]));
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});

it('can update a task', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $updated = ['name' => 'Updated Name'];
    $response = $this->putJson(route('api.v1.projects.tasks.update', [$task->project, $task]), $updated);
    $response->assertStatus(Response::HTTP_ACCEPTED)->assertJson(['message' => 'Task updated successfully!']);
    $this->assertDatabaseHas('tasks', $updated);
});

it('cannot update task with a wrong id', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $updated = ['name' => 'Updated Name'];
    $wrongId = $task->id + 1;
    $response = $this->putJson(route('api.v1.projects.tasks.update', [$task->project, $wrongId]), $updated);
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});

it('cannot update task with a wrong project id', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $updated = ['name' => 'Updated Name'];
    $wrongId = $task->project->id + 1;
    $response = $this->putJson(route('api.v1.projects.tasks.update', [$wrongId, $task]), $updated);
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});

it('cannot update task without name field', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $updated = [];
    $response = $this->putJson(route('api.v1.projects.tasks.update', [$task->project, $task]), $updated);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('can delete a task', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $response = $this->deleteJson(route('api.v1.projects.tasks.destroy', [$task->project, $task]));
    $response->assertStatus(Response::HTTP_NO_CONTENT);
    $this->assertCount(0, Task::all());
});

it('cannot delete a task with a wrong id', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $wrongId = $task->id + 1;
    $response = $this->deleteJson(route('api.v1.projects.tasks.destroy', [$task->project, $wrongId]));
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});

it('cannot delete a task with a wrong project id', function () {
    $task = Task::factory()->for(Project::factory())->create();
    $wrongId = $task->id + 1;
    $response = $this->deleteJson(route('api.v1.projects.tasks.destroy', [$wrongId, $task]));
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});

it('can reorder task', function () {
    $tasks = Task::factory(10)->for(Project::factory())->create();
    $request = [
        'new_priority' => 5,
    ];
    $response = $this->postJson(route('api.v1.projects.tasks.reorder', [$tasks->first->project, $tasks->random()]), $request);
    $response->assertStatus(Response::HTTP_ACCEPTED)->assertJson(['message' => 'Tasks reorder successfully!']);
});

it('cannot reorder task with wrong task id', function () {
    $tasks = Task::factory(10)->for(Project::factory())->create();
    $wrongId = 57;
    $request = [
        'new_priority' => 5,
    ];
    $response = $this->postJson(route('api.v1.projects.tasks.reorder', [$tasks->first->project, $wrongId]), $request);
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});

it('cannot reorder task with wrong project id', function () {
    $tasks = Task::factory(10)->for(Project::factory())->create();
    $wrongId = 57;
    $request = [
        'new_priority' => 5,
    ];
    $response = $this->postJson(route('api.v1.projects.tasks.reorder', [$wrongId, $tasks->random()]), $request);
    $response->assertStatus(Response::HTTP_NOT_FOUND);
});

it('cannot reorder task with wrong project id for task', function () {
    $tasks = Task::factory(10)->for(Project::factory())->create();
    $project = Project::factory()->create();
    $request = [
        'new_priority' => 5,
    ];
    $response = $this->postJson(route('api.v1.projects.tasks.reorder', [$project, $tasks->first()]), $request);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('cannot reorder task without new priority value', function () {
    $tasks = Task::factory(10)->for(Project::factory())->create();
    $response = $this->postJson(route('api.v1.projects.tasks.reorder', [$tasks->first->project->id, $tasks->first->id]), []);
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});
