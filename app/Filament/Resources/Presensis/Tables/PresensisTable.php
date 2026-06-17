<?php

namespace App\Filament\Resources\Presensis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PresensisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_presensi')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('pegawai.nama')
                    ->label('Pegawai')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('status_hadir')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'hadir' => 'success',
                        'alpa' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('jam_masuk')
                    ->label('Masuk')
                    ->time('H:i'),

                TextColumn::make('jam_keluar')
                    ->label('Pulang')
                    ->time('H:i'),

                TextColumn::make('terlambat_menit')
                    ->label('Terlambat')
                    ->suffix(' menit')
                    ->sortable(),

                TextColumn::make('lembur_menit')
                    ->label('Lembur')
                    ->suffix(' menit')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status_hadir')
                    ->label('Status')
                    ->options([
                        'hadir' => 'Hadir',
                        'alpa' => 'Alpa',
                    ]),

                SelectFilter::make('id_pegawai')
                    ->label('Pegawai')
                    ->relationship('pegawai', 'nama')
                    ->searchable()
                    ->preload(),
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
