<?php

namespace Database\Seeders;

use App\Models\Channel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Channel::query()
            ->insert([
                [
                    'name' => 'Snapp',
                    'description' => 'درگاه برقراری ارتباط فروش آنلاین با اسنپ',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
    }
}
