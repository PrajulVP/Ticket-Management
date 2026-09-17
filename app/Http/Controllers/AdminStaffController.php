<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminStaffController extends Controller
{
    public function index()
    {
        $staffs = User::where('role', 'staff')->latest()->paginate(10);
        return view('admin.staff.index', compact('staffs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:191',
            'email'    => 'required|string|email:rfc,dns|max:191|unique:users,email',
            'phone'    => ['nullable', 'digits:10', 'numeric'],
            'password' => 'required|string|min:8',
            'status'   => 'required|in:active,inactive',
        ], [
            'email.required'  => 'Staff email address is required.',
            'email.email'     => 'Please provide a valid email format (e.g. name@domain.com).',
            'email.unique'    => 'This email address is already registered to another user.',
            'phone.digits'    => 'The phone number must be exactly 10 digits.',
            'phone.numeric'   => 'The phone number must contain numbers only.',
            'password.required' => 'A password is required.',
            'password.min'    => 'The password must be at least 8 characters.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'staff',
            'status'   => $request->status,
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member registered successfully.');
    }

    public function update(Request $request, User $staff)
    {
        $request->validate([
            'name'     => 'required|string|max:191',
            'email'    => ['required', 'string', 'email:rfc,dns', 'max:191', Rule::unique('users')->ignore($staff->id)],
            'phone'    => ['nullable', 'digits:10', 'numeric'],
            'status'   => 'required|in:active,inactive',
            'password' => 'nullable|string|min:8',
        ], [
            'email.required'  => 'Staff email address is required.',
            'email.email'     => 'Please enter a valid email format.',
            'email.unique'    => 'This email address is already taken by another account.',
            'phone.digits'    => 'The phone number must be exactly 10 digits.',
            'phone.numeric'   => 'The phone number must contain numbers only.',
            'password.min'    => 'The password must be at least 8 characters.',
        ]);

        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $staff->update($data);

        return redirect()->route('admin.staff.index')->with('success', 'Staff details updated successfully.');
    }

    public function destroy(User $staff)
    {
        if ($staff->id === auth()->id()) {
            return redirect()->route('admin.staff.index')->with('error', 'You cannot delete your own account.');
        }

        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Staff account soft-deleted successfully.');
    }
}