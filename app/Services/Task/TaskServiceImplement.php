<?php

namespace App\Services\Task;

use App\Repositories\Task\TaskRepository;
use Illuminate\Support\Carbon;
use LaravelEasyRepository\ServiceApi;
use Livewire\WithPagination;

class TaskServiceImplement extends ServiceApi implements TaskService
{
    use WithPagination;

    /**
     * set title message api for CRUD
     * @param string $title
     */
    protected string $title = "";
    /**
     * uncomment this to override the default message
     * protected string $create_message = "";
     * protected string $update_message = "";
     * protected string $delete_message = "";
     */

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected TaskRepository $mainRepository;

    public function __construct(TaskRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
    public function getAllTasksForUser($userId)
    {
        return $this->mainRepository->getUserTasks($userId);
    }

    public function getDueTodayAlerts($userId)
    {
        return $this->mainRepository->getTasksDueToday($userId);
    }

    public function createTask($data)
    {
        return $this->mainRepository->createTask($data);
    }

    public function toggleCompleted($taskId, $userId)
    {
        return $this->mainRepository->toggleCompleted($taskId, $userId);
    }

    public function getDataUserForDashboard($search, $sortBy, int $perPage, $priority)
    {
        $userId = auth()->id();

        $todayStr = Carbon::today()->toDateString();

        return $this->mainRepository->getUserPaginatedTasks($userId, $search, $sortBy, $perPage, $priority);
    }

    public function deleteTask($id)
    {
        $userId = auth()->id();

        return $this->mainRepository->deleteTaskByUser($userId, $id);
    }
}
