<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plot;

class PlotSeeder extends Seeder
{
    public function run(): void
    {
        $rows = 5;
        $cols = 10;
        $counter = 1;

        for ($row = 1; $row <= $rows; $row++) {
            for ($col = 1; $col <= $cols; $col++) {
                Plot::create([
                    'plot_number' => 'P-' . str_pad($counter++, 3, '0', STR_PAD_LEFT),
                    'size' => rand(800, 2000),
                    'price' => rand(2000000, 10000000),
                    'location' => 'Phase ' . chr(64 + $row),
                    'status' => 'available',
                    'row_position' => $row,
                    'col_position' => $col,
                ]);
            }
        }
    }
}