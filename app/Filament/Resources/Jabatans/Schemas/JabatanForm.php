<?php

namespace App\Filament\Resources\Jabatans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class JabatanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_jabatan')
                    ->label('Nama Jabatan')
                    ->required()
                    ->maxLength(100),

                TextInput::make('gaji_pokok')
                    ->label('Gaji Pokok')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),
            ]);
    }
}
