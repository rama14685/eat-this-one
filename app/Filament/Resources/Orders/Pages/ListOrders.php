<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('printSummary')
                ->label('Print pembelian')
                ->icon('heroicon-o-printer')
                ->form([
                    Select::make('period')
                        ->label('Periode rekap')
                        ->options([
                            'day' => 'Hari ini',
                            'week' => 'Minggu ini',
                            'month' => 'Bulan ini',
                        ])
                        ->default('day')
                        ->required(),
                ])
                ->action(fn (array $data) => redirect()->route('orders.print-summary', ['period' => $data['period']])),
            CreateAction::make(),
        ];
    }
}
