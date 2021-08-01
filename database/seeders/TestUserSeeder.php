<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'test',
            'email' => 'test@email.com',
            'password' => Hash::make('password'),
        ]);

        $channel_name = 'My Test Channel';
        $user1->channel()->create([
            'uuid' => uniqid(true),
            'name' => $channel_name,
            'slug' => Str::slug($channel_name),
        ]);

        $user2 = User::create([
            'name' => 'sample',
            'email' => 'sample@email.com',
            'password' => Hash::make('password'),
        ]);

        $channel_name = 'Sample Channel';
        $user2->channel()->create([
            'uuid' => uniqid(true),
            'name' => $channel_name,
            'slug' => Str::slug($channel_name),
        ]);
    }
}
