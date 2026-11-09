<?php

namespace App\Filament\Siswa\Widgets;

use App\Models\Pengaduan;
use App\Models\Siswa;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GetPengaduan extends StatsOverviewWidget
{
    protected static ?bool $isLazyLoaded = false;

    /**
     * @var array<string, mixed>
     */
    public array $data = [];

    protected ?string $heading = 'Pengaduan Siswa';

    public function content(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make()
                    ->heading($this->getHeading())
                    ->schema([
                        Select::make('siswa_id')
                            ->label('Pilih Siswa')
                            ->options(fn (): array => Siswa::query()
                                ->orderBy('nama')
                                ->pluck('nama', 'id')
                                ->all())
                            ->searchable()
                            ->live()
                            ->required(),
                        ...$this->getStats(),
                    ])
                    ->columns(4),
            ]);
    }

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $siswaId = $this->data['siswa_id'] ?? null;

        $counts = $siswaId
            ? Pengaduan::query()
                ->where('siswa_id', $siswaId)
                ->selectRaw('status, COUNT(*) as aggregate')
                ->groupBy('status')
                ->pluck('aggregate', 'status')
            : collect();

        return [
            Stat::make('Menunggu', $counts->get('menunggu', 0)),
            Stat::make('Proses', $counts->get('proses', 0)),
            Stat::make('Selesai', $counts->get('selesai', 0)),
        ];
    }
}
