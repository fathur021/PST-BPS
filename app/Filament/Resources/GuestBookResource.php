<?php

namespace App\Filament\Resources;

use App\Enum\StatusRequestEditEnum;
use App\Enum\StatusRequestEnum;
use App\Filament\Exports\GuestBookExporter;
use App\Filament\Imports\GuestBookImporter;
use App\Filament\Resources\GuestBookResource\Pages;
use App\Filament\Resources\GuestBookResource\Widgets\GuestBookOverview;
use App\Models\GuestBook;
use App\Models\Regency;
use App\Repositories\Interface\GuestbookRepositoryInterface;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Actions\SelectAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class GuestBookResource extends Resource
{
    protected static ?string $model = GuestBook::class;

    protected static ?string $navigationLabel = 'Buku Tamu';

    protected static ?string $modelLabel = 'List Buku Tamu';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Buku Tamu';

    protected static ?int $navigationSort = 3;

    public function __construct(protected GuestbookRepositoryInterface $repository)
    {
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Identitas Pribadi')
                            ->description('Put the user name details in.')
                            ->schema([
                                TextInput::make('id')->hidden(),
                                TextInput::make('nama_lengkap')->label('Nama Lengkap')->required()->maxLength(255)->columnSpan(2),
                                Select::make('jenis_kelamin')
                                    ->label('Jenis Kelamin')
                                    ->options([
                                        'laki-laki' => 'Laki - Laki',
                                        'perempuan' => 'Perempuan',
                                    ])
                                    ->native(false)
                                    ->required(),
                                TextInput::make('usia')->required()->numeric(),
                                TextInput::make('email')->label('Email')->email()->required()->maxLength(255),
                                TextInput::make('no_hp')
                                    ->required()
                                    ->regex('/^([0-9\s\-\+\(\)]*)$/')
                                    ->minLength(10)
                                    ->maxLength(15)
                                    ->placeholder('Nomor HP (mis. 08123456789)')
                                    ->rules(['regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:15']),
                                Select::make('provinsi_id')->live()->relationship('provinsi', 'name')->preload()->required()->searchable()
                                    ->afterStateUpdated(fn (Set $set) => $set('kota_id',null)),
                                Select::make('kota_id')
                                    ->options(fn(Get $get) : Collection => Regency::query()
                                        ->where('provinsi_id', $get('provinsi_id'))
                                        ->pluck('name', 'id'))
                                    ->searchable()
                                    ->label('Kota')
                                    ->preload()
                                    ->live(),                                        
                                TextInput::make('alamat')->label('Alamat')->required()->maxLength(255)->columnSpanFull(),
                            ])
                            ->columns(2),

                        Section::make('Pekerjaan')
                            ->description('Put the user name details in.')
                            ->schema([
                                Radio::make('pekerjaan')
                                    ->options([
                                        'mahasiswa' => 'Mahasiswa',
                                        'dinas/instansi/opd' => 'Dinas/Instansi/OPD',
                                        'peneliti' => 'Peneliti',
                                        'umum' => 'Umum',
                                    ])
                                    ->live()
                                    ->reactive()
                                    ->required()
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        // Clear fields based on pekerjaan
                                        switch ($state) {
                                            case 'mahasiswa':
                                                $set('asal', null);
                                                $set('asal_universitas_lembaga', null);
                                                $set('organisasi_nama_perusahaan_kantor', null);
                                                break;
                                            case 'dinas/instansi/opd':
                                                $set('jurusan', null);
                                                $set('asal_universitas', null);
                                                $set('asal_universitas_lembaga', null);
                                                $set('organisasi_nama_perusahaan_kantor', null);
                                                break;
                                            case 'peneliti':
                                                $set('jurusan', null);
                                                $set('asal_universitas', null);
                                                $set('asal', null);
                                                $set('organisasi_nama_perusahaan_kantor', null);
                                                break;
                                            case 'umum':
                                                $set('jurusan', null);
                                                $set('asal_universitas', null);
                                                $set('asal', null);
                                                $set('asal_universitas_lembaga', null);
                                                break;
                                            default:
                                                $set('jurusan', null);
                                                $set('asal_universitas', null);
                                                $set('asal', null);
                                                $set('asal_universitas_lembaga', null);
                                                $set('organisasi_nama_perusahaan_kantor', null);
                                                break;
                                        }
                                    })
                                    ->columnSpan(2),
                                // Mahasiswa Fields
                                TextInput::make('jurusan')->maxLength(255)->visible(fn($get) => $get('pekerjaan') === 'mahasiswa'),
                                TextInput::make('asal_universitas')->label('Asal Universitas')->maxLength(255)->visible(fn($get) => $get('pekerjaan') === 'mahasiswa'),
                                // Dinas/Instansi/OPD Fields
                                TextInput::make('asal')->label('Asal')->maxLength(255)->visible(fn($get) => $get('pekerjaan') === 'dinas/instansi/opd')->columnSpanFull(),
                                // Peneliti Fields
                                TextInput::make('asal_universitas_lembaga')->label('Asal Universitas/Lembaga')->maxLength(255)->visible(fn($get) => $get('pekerjaan') === 'peneliti')->columnSpanFull(),
                                // Umum Fields
                                TextInput::make('organisasi_nama_perusahaan_kantor')->label('Organisasi/Nama Perusahaan/Kantor')->maxLength(255)->visible(fn($get) => $get('pekerjaan') === 'umum')->columnSpanFull(),
                            ])
                            ->columns(2),

                        Section::make('Tujuan Kunjungan')
                            ->description('Put the user name details in.')
                            ->schema([
                                CheckboxList::make('tujuan_kunjungan')
                                    ->label('Tujuan Kunjungan')
                                    ->options([
                                        'permintaan_data/peta' => 'Permintaan Data/Peta',
                                        'konsultasi_statistik' => 'Konsultasi Statistik',
                                        'permintaan_data_mikro' => 'Permintaan Data Mikro',
                                        'romantik' => 'Romantik',
                                        'lainnya' => 'Lainnya',
                                    ])
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        if (!in_array('lainnya', $get('tujuan_kunjungan'))) {
                                            $set('tujuan_kunjungan_lainnya', null);
                                        }
                                    })
                                    ->reactive()
                                    ->required(),

                                TextInput::make('tujuan_kunjungan_lainnya')->label('Tujuan Kunjungan Lainnya')->placeholder('Masukkan tujuan kunjungan lainnya')->visible(fn($get) => in_array('lainnya', $get('tujuan_kunjungan'))),
                            ]),
                            Group::make()
                            ->schema([
                                Section::make('Dokumen dan Tanda Tangan')
                                    ->description('Unggah dokumen yang diperlukan dan berikan tanda tangan Anda.')
                                    ->schema([
                                        FileUpload::make('bukti_identitas_diri_path')
                                            ->directory('bukti_identitas')
                                            ->acceptedFileTypes(['image/svg+xml', 'image/png', 'image/jpeg', 'application/pdf'])
                                            ->openable()
                                            ->downloadable()
                                            ->maxSize(2048),
                            
                                        FileUpload::make('dokumen_permintaan_informasi_publik_path')
                                            ->directory('bukti_identitas')
                                            ->acceptedFileTypes(['image/svg+xml', 'image/png', 'image/jpeg', 'application/pdf'])
                                            ->openable()
                                            ->downloadable()
                                            ->maxSize(2048),
                                    ]),
                            ])
                            ->columnSpan(2),
                    ])
                    ->columnSpan(2)
                    ->disabled(fn() => auth()->user()->hasRole('pst')),
                Group::make()
                    ->schema([
                        Section::make('Status Buku Tamu')
                            ->description('Tentukan status buku tamu')
                            ->schema([
                                Select::make('petugas_pst')->label('Petugas PST')->relationship('petugasPst', 'name')->native(false)->visible(fn() => auth()->user()->hasRole('admin')),
                                ToggleButtons::make('status')
                                    ->options(function () {
                                        $options = [
                                            'inProgress' => 'In Progress',
                                            'done' => 'Done',
                                            'pending' => 'Pending',
                                        ];
                                        return $options;
                                    })
                                    ->colors([
                                        'pending' => 'info',
                                        'inProgress' => 'warning',
                                        'done' => 'success',
                                    ])
                                    ->icons([
                                        'pending' => 'heroicon-m-information-circle',
                                        'inProgress' => 'heroicon-m-arrow-path',
                                        'done' => 'heroicon-m-check-badge',
                                    ])
                                    ->default('pending')
                                    ->afterStateUpdated(function ($state, $set, $get, $livewire) {
                                        // Menggunakan record dari Livewire component
                                        $record = $livewire->record;
                                        
                                        if (!$record) {
                                            return;
                                        }
                                        
                                        // Simpan perubahan status ke database
                                        if ($state === 'pending') {
                                            $record->petugas_pst = null;
                                            $record->in_progress_at = null;
                                            $record->done_at = null;
                                            $record->duration = null;
                                            $record->status = 'pending';
                                        }
                                        
                                        if ($state === 'inProgress') {
                                            $record->in_progress_at = now();
                                            $record->done_at = null;
                                            $record->duration = null;
                                            $record->status = 'inProgress';
                                        }
                                    
                                        if ($state === 'done') {
                                            $record->done_at = now();
                                            // Hitung lama waktu dari in_progress_at ke done_at
                                            if ($record->in_progress_at) {
                                                $duration = $record->done_at->diffInSeconds($record->in_progress_at);
                                                $record->duration = $duration;
                                            }
                                            $record->status = 'done';
                                        }
                                    
                                        $record->save();
                                    })
                                    ->inline()
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        $table = $table
            ->columns([
                TextColumn::make('nomor_antrian')->label('Nomor Antrian')->sortable(),
                TextColumn::make('tamu_dari')->label('Tamu dari')->sortable()
                    ->formatStateUsing(function ($state) {
                        if ($state === 'wa') {
                            return 'Tamu dari WhatsApp';
                        } else {
                            return 'Tamu dari Web';
                        }
                    }),
                TextColumn::make('jenis_layanan')->label('Jenis Layanan')->sortable(),
                TextColumn::make('nama_lengkap')->searchable()->sortable()->label('Nama Lengkap'),
                TextColumn::make('email')->searchable()->sortable()->label('Email Address'),
                TextColumn::make('pekerjaan')
                    ->searchable()
                    ->sortable()
                    ->label('Pekerjaan')
                    ->getStateUsing(function ($record) {
                        $options = [
                            'mahasiswa' => 'Mahasiswa',
                            'dinas/instansi/opd' => 'Dinas/Instansi/OPD',
                            'peneliti' => 'Peneliti',
                            'umum' => 'Umum',
                        ];

                        return $options[$record->pekerjaan] ?? $record->pekerjaan;
                    }),
                TextColumn::make('created_at')->dateTime()->sortable()->label('Tanggal Pengisian'),
                TextColumn::make('petugasPst.name')->label('Petugas PST')->searchable()->sortable()->hidden(fn() => auth()->user()->hasRole('pst')),
                SelectColumn::make('status')
                    ->label('Status')
                    ->afterStateUpdated(function ($record, $state) {
                        if (!$record) {
                            return;
                        }

                        if ($state === 'pending') {
                            $record->petugas_pst = null;
                            $record->in_progress_at = null;
                            $record->done_at = null;
                            $record->duration = null;
                        }

                        if ($state === 'inProgress') {
                            $record->in_progress_at = now();
                            $record->done_at = null;
                            $record->duration = null;
                        }
                    
                        if ($state === 'done') {
                            $record->done_at = now();
                            // Hitung lama waktu dari in_progress_at ke done_at
                            if ($record->in_progress_at) {
                                $duration = $record->done_at->diffInSeconds($record->in_progress_at);
                                $record->duration = $duration;
                                Log::info('Lama waktu in progress ke done: ' . $duration);
                            }
                        }
                    
                        $record->status = $state;
                        $record->save();
                    })
                    ->options(function () {
                        $options = [
                            'inProgress' => 'In Progress',
                            'done' => 'Done',
                            'pending' => 'Pending',
                        ];
                        return $options;
                    }),
                TextColumn::make('duration')
                    ->label('Duration ')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '-';
                        return $state . ' ';
                    }),
                TextColumn::make('in_progress_at')
                    ->label('Mulai Proses')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('done_at')
                    ->label('Selesai')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc') // <-- No urutkan berdasarkan yang terbaru
            ->actions([ActionGroup::make([ViewAction::make(), EditAction::make(), DeleteAction::make()])])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->hasRole('pst')) {
                    $userId = auth()->user()->id;
                    return $query->where('petugas_pst', $userId)->whereIn('status', ['inProgress', 'done']);
                }}
            )
            ->headerActions([
                ExportAction::make()
                    ->exporter(GuestBookExporter::class)
                    ->label('Export')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary'),
            ]);

        return $table;
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getWidgets(): array
    {
        return [GuestBookOverview::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuestBooks::route('/'),
            'create' => Pages\CreateGuestBook::route('/create'),
            'edit' => Pages\EditGuestBook::route('/{record}/edit'),
        ];
    }
}