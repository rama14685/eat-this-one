<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Order;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('order_number')->label('Nomor order'),
                TextEntry::make('customer_name')->label('Pelanggan'),
                TextEntry::make('customer_phone')->label('WhatsApp'),
                TextEntry::make('status')->label('Status')->badge(),
                TextEntry::make('ordered_at')->label('Waktu order')->dateTime('d M Y H:i'),
                TextEntry::make('items')
                    ->label('Item')
                    ->state(fn (Order $record): string => $record->items
                        ->map(fn ($item): string => "{$item->item_name} ({$item->quantity}x)")
                        ->join(', ')),
                TextEntry::make('total')->label('Total')->money('IDR', locale: 'id')->state(fn ($record): int => $record->total),
                TextEntry::make('notes')->label('Catatan')->placeholder('Tidak ada catatan')->columnSpanFull(),
            ]);
    }
}
