<?php

namespace App\Filament\Resources\Jabatans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JabatansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                 TextColumn::make('id_jabatan')
                ->label('ID')
                ->sortable(),

            TextColumn::make('nama_jabatan')
                ->label('Nama Jabatan')
                ->searchable()
                ->sortable(),

            TextColumn::make('gaji_pokok')
                ->label('Gaji Pokok')
                ->money('IDR')
                ->sortable(),

            TextColumn::make('created_at')
                ->label('Dibuat')
                ->dateTime('d M Y H:i')
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
