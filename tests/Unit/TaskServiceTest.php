<?php

use App\Repositories\Task\TaskRepository;
use App\Services\Task\TaskServiceImplement;
use Illuminate\Support\Collection;

it('mengembalikan semua tugas milik user tertentu', function () {
    // 1. Arrange (Persiapan)
    $userId = 1;

    // Kita buat tiruan (mock) dari Repository
    $mockRepository = Mockery::mock(TaskRepository::class);
    $mockRepository->shouldReceive('getUserTasks')
        ->once()
        ->with($userId)
        ->andReturn(collect([
            (object)['id' => 1, 'description' => 'Tugas 1'],
            (object)['id' => 2, 'description' => 'Tugas 2'],
        ]));

    // PERBAIKAN: Instansiasi Service ASLI dan inject mock Repository ke dalamnya
    $taskService = new TaskServiceImplement($mockRepository);

    // 2. Act (Eksekusi method asli dari service)
    $tasks = $taskService->getAllTasksForUser($userId);

    // 3. Assert (Verifikasi dengan Pest expectation)
    expect($tasks)->toBeInstanceOf(Collection::class)
        ->and($tasks)->toHaveCount(2)
        ->and($tasks->first()->description)->toBe('Tugas 1');
});