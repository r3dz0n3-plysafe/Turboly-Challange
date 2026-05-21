<?php

namespace App\Http\Controllers;

use App\Services\Task\TaskService;
use App\Traits\AdaptiveView;

class DashboardController extends Controller
{
    use AdaptiveView;

    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $tasks = $this->taskService->getDataUserForDashboard('', 'due_date', 5);
        $active = $tasks['active']->total();
        $complete = $tasks['completed']->total();
        $dueToday = $this->taskService->getDueTodayAlerts(auth()->id())->count();

        return $this->renderView('dashboard.index', compact('active', 'complete', 'dueToday'));
    }
}
