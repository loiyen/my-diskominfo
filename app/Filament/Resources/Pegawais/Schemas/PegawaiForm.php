<?php

namespace App\Filament\Resources\Pegawais\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PegawaiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('nama')
                    ->required()
                    ->maxLength(150),

                Select::make('gelar')
                    ->options([
                        'D3' => 'D3',
                        'S1' => 'S1',
                        'S2' => 'S2',
                    ])
                    ->required(),
                Select::make('id_jabatan')
                    ->relationship('jabatan', 'nama_jabatan')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
