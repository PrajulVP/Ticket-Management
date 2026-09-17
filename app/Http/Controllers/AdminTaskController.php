<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTaskController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $tasks = Task::with('assignedStaff')
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Only active staff can be assigned tasks
        $activeStaffs = User::activeStaff()->get();

        return view('admin.tasks.index', compact('tasks', 'activeStaffs', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'description' => 'nullable|string',
            'status' => 'required|in:Open,Completed',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        Task::create($request->only('title', 'description', 'status', 'assigned_to'));

        return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully.');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'description' => 'nullable|string',
            'status' => 'required|in:Open,Completed',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task->update($request->only('title', 'description', 'status', 'assigned_to'));

        return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks.index')->with('success', 'Task soft-deleted successfully.');
    }
}