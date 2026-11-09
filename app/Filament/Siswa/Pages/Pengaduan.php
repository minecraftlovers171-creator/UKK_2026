<?php

namespace App\Filament\Siswa\Pages;

use App\Models\Pengaduan as PengaduanModel;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class Pengaduan extends Page
{
    public ?array $data = [];

    protected string $view = 'filament.siswa.pages.pengaduan';

    protected static ?string $title = 'Create Pengaduan';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
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
            ])
            ->model(PengaduanModel::class)
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        PengaduanModel::create([
            ...$data,
            'status' => 'menunggu',
        ]);

        Notification::make()
            ->title('Pengaduan created successfully')
            ->success()
            ->send();

        $this->form->fill();
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('create')
                    ->footer([
                        Actions::make([
                            Action::make('create')
                                ->label('Create Pengaduan')
                                ->submit('create'),
                        ]),
                    ]),
            ]);
    }
}
