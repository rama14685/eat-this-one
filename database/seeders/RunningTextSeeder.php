<?php

namespace Database\Seeders;

use App\Models\RunningText;
use Illuminate\Database\Seeder;

class RunningTextSeeder extends Seeder
{
    public function run(): void
    {
        RunningText::firstOrCreate([
            'content' => 'Manis, gurih, dan siap bikin harimu lebih seru! Pesan sekarang via WhatsApp Eat This One.',
        ], [
            'speed' => 'normal',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }
}
