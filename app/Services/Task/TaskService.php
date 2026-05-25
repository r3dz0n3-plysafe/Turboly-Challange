<?php

namespace App\Services\Task;

use LaravelEasyRepository\BaseService;

interface TaskService extends BaseService
{

    // Write something awesome :)
    public function getAllTasksForUser($userId);

    public function getDueTodayAlerts($userId);

    public function createTask($data);

    public function toggleCompleted($taskId, $userId);

    public function getDataUserForDashboard($search, $sortBy, int $perPage, $priority);

    public function deleteTask($id);

}
