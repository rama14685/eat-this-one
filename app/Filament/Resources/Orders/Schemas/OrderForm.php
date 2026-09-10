<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_number')->label('Nomor order')->disabled(),
                TextInput::make('customer_name')->label('Nama pelanggan')->required(),
                TextInput::make('customer_phone')->label('Nomor WhatsApp')->required(),
                Select::make('status')->label('Status')->options([
                    'pending' => 'Menunggu', 'confirmed' => 'Dikonfirmasi', 'processing' => 'Diproses', 'done' => 'Selesai', 'cancelled' => 'Dibatalkan',
                ])->required(),
                Textarea::make('notes')->label('Catatan')->columnSpanFull(),
            ]);
    }
}
