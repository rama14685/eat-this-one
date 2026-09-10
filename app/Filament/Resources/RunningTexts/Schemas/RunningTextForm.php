<?php

namespace App\Filament\Resources\RunningTexts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RunningTextForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('content')->label('Teks berjalan')->required()->rows(3)->columnSpanFull(),
                Select::make('speed')->label('Kecepatan')->options(['slow' => 'Pelan', 'normal' => 'Normal', 'fast' => 'Cepat'])->required()->default('normal'),
                TextInput::make('sort_order')->label('Urutan')->numeric()->default(0)->required(),
                Toggle::make('is_active')->label('Tampilkan di katalog')->default(true),
            ]);
    }
}
