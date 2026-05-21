<?php

namespace App\Repositories\Task;

use LaravelEasyRepository\Repository;

interface TaskRepository extends Repository
{

    // Write something awesome :)
    public function getUserTasks($userId);

    public function createTask(array $data);

    public function toggleCompleted($taskId, $userId);

    public function getTasksDueToday($userId);

    public function getUserPaginatedTasks($userId, $search, $sortBy, int $perPage);
}
