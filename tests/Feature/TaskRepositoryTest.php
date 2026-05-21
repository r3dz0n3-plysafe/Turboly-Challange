<?php

use App\Models\Task;
use App\Models\User;
use App\Repositories\Task\TaskRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('dapat membuat task baru ke dalam database', function () {
    $user = User::factory()->create();

    // PERBAIKAN: Resolve lewat Service Container agar model Task otomatis ter-inject
    $repository = app(TaskRepository::class);

    $taskData = [
        'user_id' => $user->id,
        'description' => 'Test Create Task',
        'due_date' => Carbon::tomorrow()->format('Y-m-d'),
        'priority' => 'high',
        'is_completed' => false,
    ];

    $task = $repository->createTask($taskData);

    // Verifikasi hasil return
    expect($task)->toBeInstanceOf(Task::class)
        ->and($task->description)->toBe('Test Create Task');

    // Verifikasi data benar-benar masuk ke database
    $this->assertDatabaseHas('tasks', [
        'user_id' => $user->id,
        'description' => 'Test Create Task',
        'priority' => 'high'
    ]);
});

it('dapat mengambil tugas yang tenggat waktunya hari ini', function () {
    $user = User::factory()->create();

    // PERBAIKAN: Resolve lewat Service Container agar model Task otomatis ter-inject
    $repository = app(TaskRepository::class);

    // Buat task untuk hari ini di database via Factory
    Task::factory()->create([
        'user_id' => $user->id,
        'due_date' => Carbon::today()->format('Y-m-d'),
        'is_completed' => false
    ]);

    // Buat task untuk besok (seharusnya tidak terambil)
    Task::factory()->create([
        'user_id' => $user->id,
        'due_date' => Carbon::tomorrow()->format('Y-m-d'),
        'is_completed' => false
    ]);

    $dueTodayTasks = $repository->getTasksDueToday($user->id);

    expect($dueTodayTasks)->toHaveCount(1)
        ->and(Carbon::parse($dueTodayTasks->first()->due_date)->isToday())->toBeTrue();

});