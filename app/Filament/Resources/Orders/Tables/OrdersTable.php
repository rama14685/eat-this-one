<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')->label('No. Order')->searchable()->sortable(),
                TextColumn::make('customer_name')->label('Pelanggan')->searchable(),
                TextColumn::make('customer_phone')->label('WhatsApp'),
                TextColumn::make('status')->label('Status')->badge(),
                TextColumn::make('total')->label('Total')->money('IDR', locale: 'id')->state(fn ($record): int => $record->total),
                TextColumn::make('ordered_at')->label('Dipesan')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'pending' => 'Menunggu', 'confirmed' => 'Dikonfirmasi', 'processing' => 'Diproses', 'done' => 'Selesai', 'cancelled' => 'Dibatalkan',
                ]),
                SelectFilter::make('period')
                    ->label('Periode pembelian')
                    ->options([
                        'day' => 'Hari ini',
                        'week' => 'Minggu ini',
                        'month' => 'Bulan ini',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value'] ?? null) {
                            'day' => $query->whereBetween('ordered_at', [now()->startOfDay(), now()->endOfDay()]),
                            'week' => $query->whereBetween('ordered_at', [now()->startOfWeek(), now()->endOfWeek()]),
                            'month' => $query->whereBetween('ordered_at', [now()->startOfMonth(), now()->endOfMonth()]),
                            default => $query,
                        };
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
