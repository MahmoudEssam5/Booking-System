<?php

namespace Database\Seeders;

use App\Models\HrProfile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HRProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Ahmed HR',
            'email' => 'ahmed@example.com',
            'password' => Hash::make('password'),
            'role' => 'hr_manager',
        ])->each(function ($user) {
            HRProfile::create([
                'user_id' => $user->id,
                'department' => 'Tech',
                'position' => 'HR Lead',
                'booking_link_slug' => Str::slug($user->name),
            ]);
        });
    }
}
