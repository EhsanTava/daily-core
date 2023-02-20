<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Channel;
use App\Models\Status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ChannelSeeder::class,
            StatusSeeder::class
        ]);

        Status::query()
            ->insert([
                [
                    'id' => 1,
                    'title' => 'sth',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 2,
                    'title' => 'sth',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 3,
                    'title' => 'sth',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 56,
                    'title' => 'sth',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
    }
}
