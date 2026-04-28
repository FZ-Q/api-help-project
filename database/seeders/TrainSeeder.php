<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Train;
use App\Enums\TrainClass;

class TrainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trains = [
            ['name' => 'Argo Bromo Anggrek', 'class' => TrainClass::PREMIUM],
            ['name' => 'Taksaka', 'class' => TrainClass::PREMIUM],
            ['name' => 'Gajayana', 'class' => TrainClass::PREMIUM],
            ['name' => 'Senja Utama Solo', 'class' => TrainClass::BUSINESS],
            ['name' => 'Fajar Utama YK', 'class' => TrainClass::BUSINESS],
            ['name' => 'Sawunggalih', 'class' => TrainClass::BUSINESS],
            ['name' => 'Airlangga', 'class' => TrainClass::ECONOMY],
            ['name' => 'Bengawan', 'class' => TrainClass::ECONOMY],
            ['name' => 'Progo', 'class' => TrainClass::ECONOMY],
            ['name' => 'Serayu', 'class' => TrainClass::ECONOMY],
        ];

        foreach ($trains as $train) {
            Train::create($train);
        }
    }
}
