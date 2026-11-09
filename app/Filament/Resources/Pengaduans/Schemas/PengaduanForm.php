<?php

namespace App\Filament\Resources\Pengaduans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PengaduanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('siswa_id')
                    ->relationship('siswa', 'nama')
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'nama')
                    ->required(),
                TextInput::make('tempat')
                    ->required(),
                Textarea::make('deskripsi_peminjaman')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'proses' => 'Proses',
                        'selesai' => 'Selesai',
                    ])
                    ->required()
                    ->default('menunggu'),
                Textarea::make('feedback')
                    ->columnSpanFull(),
            ]);
    }
}
