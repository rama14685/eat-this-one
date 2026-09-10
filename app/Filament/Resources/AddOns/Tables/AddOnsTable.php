<?php

namespace App\Filament\Resources\AddOns\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class AddOnsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('Gambar')->disk('public'),
                TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                TextColumn::make('price')->label('Harga')->money('IDR', locale: 'id')->sortable(),
                TextColumn::make('duration')->label('Durasi'),
                TextColumn::make('stars')->label('Rating')->formatStateUsing(fn ($state): string => str_repeat('★', (int) $state)),
                ToggleColumn::make('is_active')->label('Aktif'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
