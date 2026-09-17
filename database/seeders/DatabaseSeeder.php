<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default Admin (as specified in requirement)
        $admin = User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'status' => 'active',
                'phone' => '9876543210',
            ]
        );

        // Sample Active Staff
        $staff1 = User::updateOrCreate(
            ['email' => 'staff1@test.com'],
            [
                'name' => 'Rahul Sharma',
                'password' => Hash::make('12345678'),
                'role' => 'staff',
                'status' => 'active',
                'phone' => '9876543211',
            ]
        );

        $staff2 = User::updateOrCreate(
            ['email' => 'staff2@test.com'],
            [
                'name' => 'Anjali Nair',
                'password' => Hash::make('12345678'),
                'role' => 'staff',
                'status' => 'active',
                'phone' => '9876543212',
            ]
        );

        // Seed Sample Tasks
        Task::create([
            'title' => 'Server Security Patching',
            'description' => 'Update firewall rules and patch OpenSSL packages on prod.',
            'status' => 'Completed',
            'assigned_to' => $staff1->id,
        ]);

        Task::create([
            'title' => 'Database Backup Optimization',
            'description' => 'Set up automated daily S3 backup cron jobs.',
            'status' => 'Open',
            'assigned_to' => $staff1->id,
        ]);

        Task::create([
            'title' => 'Resolve SSL Certificate Issue',
            'description' => 'Renew wildcard Let\'s Encrypt certificate.',
            'status' => 'Completed',
            'assigned_to' => $staff2->id,
        ]);
    }
}