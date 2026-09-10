<?php

namespace Database\Seeders;

use App\Models\AddOn;
use Illuminate\Database\Seeder;

class AddOnSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'Styrofoam Box 50pcs', 'slug' => 'styrofoam-box-50pcs', 'description' => 'Isolasi paling baik untuk 50pcs bag.', 'duration' => '4-6 jam', 'price' => 35000, 'stars' => 5],
            ['name' => 'Kardus', 'slug' => 'kardus', 'description' => 'Kemasan luar yang praktis.', 'duration' => '30-60 menit', 'price' => 3000, 'stars' => 1],
            ['name' => 'Ice Pack', 'slug' => 'ice-pack', 'description' => 'Menjaga suhu dingin lebih lama.', 'duration' => '2-4 jam', 'price' => 15000, 'stars' => 5],
            ['name' => 'Thermal Bag', 'slug' => 'thermal-bag', 'description' => 'Membantu memperlambat kenaikan suhu.', 'duration' => '1-2 jam', 'price' => 5000, 'stars' => 2],
            ['name' => 'Extra Ice Gel', 'slug' => 'extra-ice-gel', 'description' => 'Tambahan durasi pendinginan.', 'duration' => '2-4 jam', 'price' => 4000, 'stars' => 3],
            ['name' => 'Plastic Safety', 'slug' => 'plastic-safety', 'description' => 'Perlindungan tambahan es krim.', 'duration' => '30-60 menit', 'price' => 500, 'stars' => 1],
        ] as $addOn) {
            AddOn::updateOrCreate(['slug' => $addOn['slug']], $addOn);
        }
    }
}
