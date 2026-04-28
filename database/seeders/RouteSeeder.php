<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('routes')->insert([
            // Routes for Train ID 1 (e.g., Jakarta to Surabaya)
            ['train_id' => 1, 'location' => 'Jakarta Gambir', 'arrival_time' => '08:00:00', 'order' => 1, 'created_at' => now()],
            ['train_id' => 1, 'location' => 'Cirebon', 'arrival_time' => '11:00:00', 'order' => 2, 'created_at' => now()],
            ['train_id' => 1, 'location' => 'Semarang Tawang', 'arrival_time' => '13:30:00', 'order' => 3, 'created_at' => now()],
            ['train_id' => 1, 'location' => 'Surabaya Pasar Turi', 'arrival_time' => '16:00:00', 'order' => 4, 'created_at' => now()],

            // Routes for Train ID 2 (e.g., Bandung to Yogyakarta)
            ['train_id' => 2, 'location' => 'Bandung', 'arrival_time' => '07:00:00', 'order' => 1, 'created_at' => now()],
            ['train_id' => 2, 'location' => 'Banjar', 'arrival_time' => '10:30:00', 'order' => 2, 'created_at' => now()],
            ['train_id' => 2, 'location' => 'Yogyakarta', 'arrival_time' => '14:00:00', 'order' => 3, 'created_at' => now()],

            // Routes for Train ID 3 (e.g., Surabaya to Solo)
            ['train_id' => 3, 'location' => 'Surabaya Gubeng', 'arrival_time' => '09:00:00', 'order' => 1, 'created_at' => now()],
            ['train_id' => 3, 'location' => 'Madiun', 'arrival_time' => '11:15:00', 'order' => 2, 'created_at' => now()],
            ['train_id' => 3, 'location' => 'Solo Balapan', 'arrival_time' => '12:45:00', 'order' => 3, 'created_at' => now()],
        ]);
    }
}
