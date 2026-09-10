<?php

namespace App\Filament\Resources\AddOns\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AddOnForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nama add-on')->required(),
                TextInput::make('slug')->required()->unique(ignoreRecord: true),
                TextInput::make('price')->label('Harga')->numeric()->required()->prefix('Rp'),
                TextInput::make('duration')->label('Durasi perlindungan')->placeholder('2-4 jam'),
                TextInput::make('stars')->label('Rating bintang')->numeric()->minValue(1)->maxValue(5)->default(3)->required(),
                Textarea::make('description')->label('Deskripsi')->columnSpanFull(),
                FileUpload::make('image')->label('Gambar add-on')->image()->disk('public')->directory('add-ons')->imageEditor()->maxSize(5120),
                Toggle::make('is_active')->label('Tampilkan di katalog')->default(true),
            ]);
    }
}
