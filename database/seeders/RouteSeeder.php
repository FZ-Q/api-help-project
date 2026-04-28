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
            // Train ID 1: Argo Bromo Anggrek (Jakarta -> Surabaya)
            ['train_id' => 1, 'location' => 'Jakarta Gambir', 'arrival_time' => '08:00:00', 'order' => 1, 'created_at' => now()],
            ['train_id' => 1, 'location' => 'Cirebon', 'arrival_time' => '11:00:00', 'order' => 2, 'created_at' => now()],
            ['train_id' => 1, 'location' => 'Semarang Tawang', 'arrival_time' => '13:30:00', 'order' => 3, 'created_at' => now()],
            ['train_id' => 1, 'location' => 'Surabaya Pasar Turi', 'arrival_time' => '16:00:00', 'order' => 4, 'created_at' => now()],

            // Train ID 2: Turangga (Bandung -> Yogyakarta -> Surabaya)
            ['train_id' => 2, 'location' => 'Bandung', 'arrival_time' => '18:00:00', 'order' => 1, 'created_at' => now()],
            ['train_id' => 2, 'location' => 'Cipeundeuy', 'arrival_time' => '19:45:00', 'order' => 2, 'created_at' => now()],
            ['train_id' => 2, 'location' => 'Tasikmalaya', 'arrival_time' => '20:30:00', 'order' => 3, 'created_at' => now()],
            ['train_id' => 2, 'location' => 'Banjar', 'arrival_time' => '21:15:00', 'order' => 4, 'created_at' => now()],
            ['train_id' => 2, 'location' => 'Kroya', 'arrival_time' => '23:00:00', 'order' => 5, 'created_at' => now()],
            ['train_id' => 2, 'location' => 'Yogyakarta', 'arrival_time' => '00:30:00', 'order' => 6, 'created_at' => now()],

            // Train ID 3: Sancaka (Surabaya -> Solo -> Yogyakarta)
            ['train_id' => 3, 'location' => 'Surabaya Gubeng', 'arrival_time' => '09:00:00', 'order' => 1, 'created_at' => now()],
            ['train_id' => 3, 'location' => 'Mojokerto', 'arrival_time' => '09:35:00', 'order' => 2, 'created_at' => now()],
            ['train_id' => 3, 'location' => 'Madiun', 'arrival_time' => '10:50:00', 'order' => 3, 'created_at' => now()],
            ['train_id' => 3, 'location' => 'Solo Balapan', 'arrival_time' => '12:05:00', 'order' => 4, 'created_at' => now()],
            ['train_id' => 3, 'location' => 'Yogyakarta', 'arrival_time' => '13:00:00', 'order' => 5, 'created_at' => now()],

            // Train ID 4: Taksaka (Yogyakarta -> Jakarta) - Night Express
            ['train_id' => 4, 'location' => 'Yogyakarta', 'arrival_time' => '21:00:00', 'order' => 1, 'created_at' => now()],
            ['train_id' => 4, 'location' => 'Kebumen', 'arrival_time' => '22:15:00', 'order' => 2, 'created_at' => now()],
            ['train_id' => 4, 'location' => 'Purwokerto', 'arrival_time' => '23:40:00', 'order' => 3, 'created_at' => now()],
            ['train_id' => 4, 'location' => 'Cirebon', 'arrival_time' => '01:30:00', 'order' => 4, 'created_at' => now()],
            ['train_id' => 4, 'location' => 'Jakarta Gambir', 'arrival_time' => '04:15:00', 'order' => 5, 'created_at' => now()],

            // Train ID 5: Serayu (Jakarta -> Purwokerto via South Path)
            ['train_id' => 5, 'location' => 'Jakarta Pasar Senen', 'arrival_time' => '20:10:00', 'order' => 1, 'created_at' => now()],
            ['train_id' => 5, 'location' => 'Bekasi', 'arrival_time' => '20:40:00', 'order' => 2, 'created_at' => now()],
            ['train_id' => 5, 'location' => 'Purwakarta', 'arrival_time' => '21:55:00', 'order' => 3, 'created_at' => now()],
            ['train_id' => 5, 'location' => 'Cimahi', 'arrival_time' => '23:15:00', 'order' => 4, 'created_at' => now()],
            ['train_id' => 5, 'location' => 'Bandung Kiaracondong', 'arrival_time' => '23:45:00', 'order' => 5, 'created_at' => now()],
            ['train_id' => 5, 'location' => 'Sidareja', 'arrival_time' => '02:30:00', 'order' => 6, 'created_at' => now()],
            ['train_id' => 5, 'location' => 'Purwokerto', 'arrival_time' => '04:00:00', 'order' => 7, 'created_at' => now()],

            // Train ID 6: Argo Parahyangan (Jakarta Gambir -> Bandung)
            // Short, intense route perfect for testing rapid progress updates
            ['train_id' => 6, 'location' => 'Jakarta Gambir', 'arrival_time' => '18:30:00', 'order' => 1, 'created_at' => now()],
            ['train_id' => 6, 'location' => 'Bekasi', 'arrival_time' => '19:05:00', 'order' => 2, 'created_at' => now()],
            ['train_id' => 6, 'location' => 'Cimahi', 'arrival_time' => '21:00:00', 'order' => 3, 'created_at' => now()],
            ['train_id' => 6, 'location' => 'Bandung', 'arrival_time' => '21:15:00', 'order' => 4, 'created_at' => now()],

            // Train ID 7: Kertajaya (Jakarta Pasar Senen -> Surabaya Pasar Turi)
            // Very long route with many small stops to test "busy" maps
            ['train_id' => 7, 'location' => 'Jakarta Pasar Senen', 'arrival_time' => '14:30:00', 'order' => 1, 'created_at' => now()],
            ['train_id' => 7, 'location' => 'Cirebon Prujakan', 'arrival_time' => '17:30:00', 'order' => 2, 'created_at' => now()],
            ['train_id' => 7, 'location' => 'Tegal', 'arrival_time' => '18:45:00', 'order' => 3, 'created_at' => now()],
            ['train_id' => 7, 'location' => 'Pekalongan', 'arrival_time' => '19:50:00', 'order' => 4, 'created_at' => now()],
            ['train_id' => 7, 'location' => 'Semarang Poncol', 'arrival_time' => '21:10:00', 'order' => 5, 'created_at' => now()],
            ['train_id' => 7, 'location' => 'Cepu', 'arrival_time' => '23:40:00', 'order' => 6, 'created_at' => now()],
            ['train_id' => 7, 'location' => 'Bojonegoro', 'arrival_time' => '00:20:00', 'order' => 7, 'created_at' => now()],
            ['train_id' => 7, 'location' => 'Surabaya Pasar Turi', 'arrival_time' => '01:35:00', 'order' => 8, 'created_at' => now()],

            // Train ID 8: Joglosemarkerto (Looping Central Java)
            // Great for testing mid-day tracking
            ['train_id' => 8, 'location' => 'Solo Balapan', 'arrival_time' => '06:00:00', 'order' => 1, 'created_at' => now()],
            ['train_id' => 8, 'location' => 'Yogyakarta', 'arrival_time' => '06:55:00', 'order' => 2, 'created_at' => now()],
            ['train_id' => 8, 'location' => 'Kutoarjo', 'arrival_time' => '07:50:00', 'order' => 3, 'created_at' => now()],
            ['train_id' => 8, 'location' => 'Purwokerto', 'arrival_time' => '09:40:00', 'order' => 4, 'created_at' => now()],
            ['train_id' => 8, 'location' => 'Tegal', 'arrival_time' => '11:55:00', 'order' => 5, 'created_at' => now()],
            ['train_id' => 8, 'location' => 'Semarang Tawang', 'arrival_time' => '14:20:00', 'order' => 6, 'created_at' => now()],

            // Train ID 9: Argo Wilis (Bandung -> Surabaya Gubeng via South)
            // Premium scenic route
            ['train_id' => 9, 'location' => 'Bandung', 'arrival_time' => '07:40:00', 'order' => 1, 'created_at' => now()],
            ['train_id' => 9, 'location' => 'Tasikmalaya', 'arrival_time' => '10:45:00', 'order' => 2, 'created_at' => now()],
            ['train_id' => 9, 'location' => 'Banjar', 'arrival_time' => '11:35:00', 'order' => 3, 'created_at' => now()],
            ['train_id' => 9, 'location' => 'Kroya', 'arrival_time' => '13:05:00', 'order' => 4, 'created_at' => now()],
            ['train_id' => 9, 'location' => 'Yogyakarta', 'arrival_time' => '14:35:00', 'order' => 5, 'created_at' => now()],
            ['train_id' => 9, 'location' => 'Solo Balapan', 'arrival_time' => '15:25:00', 'order' => 6, 'created_at' => now()],
            ['train_id' => 9, 'location' => 'Madiun', 'arrival_time' => '16:40:00', 'order' => 7, 'created_at' => now()],
            ['train_id' => 9, 'location' => 'Surabaya Gubeng', 'arrival_time' => '18:10:00', 'order' => 8, 'created_at' => now()],

            // Train ID 10: Whoosh (Halim -> Tegalluar)
            // Total journey time is only 46 minutes
            ['train_id' => 10, 'location' => 'Halim Jakarta', 'arrival_time' => '15:02:00', 'order' => 1, 'created_at' => now()],
            ['train_id' => 10, 'location' => 'Karawang', 'arrival_time' => '15:17:00', 'order' => 2, 'created_at' => now()],
            ['train_id' => 10, 'location' => 'Padalarang', 'arrival_time' => '15:34:00', 'order' => 3, 'created_at' => now()],
            ['train_id' => 10, 'location' => 'Tegalluar Bandung', 'arrival_time' => '15:48:00', 'order' => 4, 'created_at' => now()],
        ]);
    }
}
