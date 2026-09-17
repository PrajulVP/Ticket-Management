<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalStaff = User::where('role', 'staff')->count();
        $totalTasks = Task::count();
        $openTasks = Task::where('status', 'Open')->count();
        $closedTasks = Task::where('status', 'Completed')->count();

        // Top 5 active staff members by completed tasks
        $topPerformers = User::activeStaff()
            ->withCount(['tasks as completed_count' => function ($q) {
                $q->where('status', 'Completed');
            }])
            ->orderByDesc('completed_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalStaff',
            'totalTasks',
            'openTasks',
            'closedTasks',
            'topPerformers'
        ));
    }
}