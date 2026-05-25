<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Services\Task\TaskService;
use App\Traits\AdaptiveView;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use AdaptiveView;

    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search', '');
            $sortBy = $request->input('sortBy', 'due_date');
            $filterBy = $request->input('filterBy', '');
            $perPage = 5;

            $data = $this->taskService->getDataUserForDashboard(
                $search,
                $sortBy,
                $perPage,
                $filterBy
            );
            return response()->json($data);
        }

        return $this->renderView('tasks.index');
    }

    public function store(TaskRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $this->taskService->createTask($data);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function toggleComplete($id)
    {
        $this->taskService->toggleCompleted($id, auth()->id());

        return redirect()->back()->with('success', 'Task marked as completed.');
    }

    public function taskDelete(Request $request, $id)
    {
        $this->taskService->deleteTask($id);

        return redirect()->back()->with('success', 'Task deleted successfully.');
    }
}
