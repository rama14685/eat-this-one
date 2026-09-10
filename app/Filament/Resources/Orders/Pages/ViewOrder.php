<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->label('Print rekap')
                ->icon('heroicon-o-printer')
                ->url(fn (Order $record): string => route('orders.print', $record))
                ->openUrlInNewTab(),
            EditAction::make(),
        ];
    }
}
