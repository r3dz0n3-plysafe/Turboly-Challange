<?php

namespace App\Repositories\Task;

use App\Models\Task;
use Illuminate\Support\Carbon;
use LaravelEasyRepository\Implementations\Eloquent;

class TaskRepositoryImplement extends Eloquent implements TaskRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Task $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function getUserPaginatedTasks($userId, $search, $sortBy, int $perPage)
    {
        $query = $this->model->select('id', 'description', 'due_date', 'priority', 'is_completed')
            ->where('user_id', $userId);

        if (!empty($search)) {
            $query->where('description', 'like', '%' . $search . '%');
        }

        // Fitur Pengurutan dinamis
        if ($sortBy === 'priority') {
            $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low')");
        } else {
            $query->orderBy($sortBy, 'asc');
        }

        // Ambil data Tugas Aktif (Menggunakan resolver halaman 'page_active')
        $activeTasks = (clone $query)->where('is_completed', false)
            ->paginate($perPage, ['*'], 'page_active');

        // Ambil data Tugas Selesai (Menggunakan resolver halaman 'page_completed')
        $completedTasks = (clone $query)->where('is_completed', true)
            ->paginate($perPage, ['*'], 'page_completed');

        return [
            'active' => $activeTasks,
            'completed' => $completedTasks,
        ];
    }

    // Write something awesome :)
    public function getUserTasks($userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }

    public function createTask(array $data)
    {
        return $this->model->create($data);
    }

    public function toggleCompleted($taskId, $userId)
    {
        $task = $this->model->where('id', $taskId)->where('user_id', $userId)->firstOrFail();
        $task->update(['is_completed' => !$task->is_completed]);
        return $task;
    }

    public function getTasksDueToday($userId)
    {
        return $this->model->where('user_id', $userId)
            ->whereDate('due_date', Carbon::today())
            ->where('is_completed', false)
            ->get();
    }
}
