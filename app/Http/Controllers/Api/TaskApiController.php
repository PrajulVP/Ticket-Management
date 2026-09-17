<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskApiController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $query = Task::with('assignedStaff:id,name,email');

        // Search API: by title
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filtering API: by status or assigned_to
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Sorting API
        $sortBy = $request->query('sort_by', 'created_at');
        $sortOrder = $request->query('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination API
        $perPage = $request->query('per_page', 10);
        $tasks = $query->paginate($perPage);

        return $this->successResponse($tasks, 'Tasks retrieved successfully');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:191',
            'description' => 'nullable|string',
            'status' => 'required|in:Open,Completed',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task = Task::create($validated);
        return $this->successResponse($task, 'Task created successfully', 201);
    }

    public function show(Task $task)
    {
        return $this->successResponse($task->load('assignedStaff:id,name,email'), 'Task details');
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:191',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:Open,Completed',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task->update($validated);
        return $this->successResponse($task, 'Task updated successfully');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return $this->successResponse(null, 'Task soft-deleted successfully');
    }
}