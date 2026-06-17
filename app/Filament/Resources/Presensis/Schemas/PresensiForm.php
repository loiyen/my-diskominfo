<?php

namespace App\Filament\Resources\Presensis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class PresensiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_pegawai')
                    ->label('Pegawai')
                    ->relationship('pegawai', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required(),

                Select::make('status_hadir')
                    ->label('Status Hadir')
                    ->options([
                        'hadir' => 'Hadir',
                        'alpa' => 'Alpa',
                    ])
                    ->default('hadir')
                    ->live()
                    ->required(),

                TimePicker::make('jam_masuk')
                    ->label('Jam Masuk')
                    ->seconds(false)
                    ->hidden(fn(Get $get) => $get('status_hadir') === 'alpa'),

                TimePicker::make('jam_keluar')
                    ->label('Jam Keluar')
                    ->seconds(false)
                    ->hidden(fn(Get $get) => $get('status_hadir') === 'alpa'),

                TimePicker::make('jam_masuk_normal')
                    ->label('Jam Masuk Normal')
                    ->default('09:00')
                    ->seconds(false)
                    ->required(),

                TimePicker::make('jam_keluar_normal')
                    ->label('Jam Keluar Normal')
                    ->default('17:00')
                    ->seconds(false)
                    ->required(),

                TextInput::make('terlambat_menit')
                    ->label('Terlambat Menit')
                    ->numeric()
                    ->default(0)
                    ->required(),

                TextInput::make('lembur_menit')
                    ->label('Lembur Menit')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }
}
