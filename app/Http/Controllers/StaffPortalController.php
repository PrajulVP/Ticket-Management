<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffPortalController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();
        $totalAssigned = Task::where('assigned_to', $userId)->count();
        $openTasks = Task::where('assigned_to', $userId)->where('status', 'Open')->count();
        $completedTasks = Task::where('assigned_to', $userId)->where('status', 'Completed')->count();
        $recentTasks = Task::where('assigned_to', $userId)->latest()->take(5)->get();

        return view('staff.dashboard', compact(
            'totalAssigned', 
            'openTasks', 
            'completedTasks', 
            'recentTasks'
        ));
    }

    public function tasks(Request $request)
    {
        $search = $request->query('search');

        $tasks = Task::where('assigned_to', Auth::id())
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('staff.tasks.index', compact('tasks', 'search'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        if ($task->assigned_to !== Auth::id()) {
            abort(403, 'Unauthorized action on this task.');
        }

        $request->validate([
            'status' => 'required|in:Open,Completed',
        ]);

        $task->update(['status' => $request->status]);

        return back()->with('success', 'Task status updated.');
    }

    public function editProfile()
    {
        return view('staff.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:191',
            'phone' => ['required', 'digits:10', 'numeric'],
        ], [
            'name.required'  => 'Your full name is required.',
            'phone.required' => 'A contact phone number is required.',
            'phone.digits'   => 'The phone number must be exactly 10 digits.',
            'phone.numeric'  => 'The phone number must contain numbers only.',
        ]);

        $request->user()->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Your profile details have been updated.');
    }
}