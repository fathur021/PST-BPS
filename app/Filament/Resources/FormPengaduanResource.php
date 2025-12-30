<?php

namespace App\Filament\Resources;

use App\Filament\Exports\FormPengaduanExporter;
use App\Filament\Resources\FormPengaduanResource\Pages;
use App\Filament\Resources\FormPengaduanResource\RelationManagers;
use App\Models\FormPengaduan;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FormPengaduanResource extends Resource
{
    protected static ?string $model = FormPengaduan::class;
    protected static ?string $navigationLabel = 'Pengaduan';

    protected static ?string $modelLabel = 'List Pengaduan';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Pengaduan';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section for Basic Identity Information
                Group::make()
                    ->schema([
                        Section::make('Identitas Pribadi')
                            ->description('Masukkan informasi dasar identitas pribadi Anda.')
                            ->schema([Forms\Components\TextInput::make('nama_lengkap')->required()->maxLength(255), Forms\Components\Textarea::make('alamat')->columnSpanFull(), Forms\Components\TextInput::make('pekerjaan')->maxLength(255), Forms\Components\TextInput::make('no_hp')->maxLength(255), Forms\Components\TextInput::make('email')->email()->maxLength(255)]),
                    ])
                    ->columnSpan(1)
                    ->disabledOn('edit'),

                // Section for Additional Information
                Group::make()
                    ->schema([
                        Section::make('Informasi Tambahan')
                            ->description('Masukkan rincian informasi tambahan dan tujuan penggunaan informasi.')
                            ->schema([Forms\Components\Textarea::make('rincian_informasi')->columnSpanFull(), Forms\Components\Textarea::make('tujuan_penggunaan_informasi')->columnSpanFull(), Forms\Components\TextInput::make('cara_memperoleh_informasi')->maxLength(255), Forms\Components\TextInput::make('cara_mendapatkan_salinan_informasi')->maxLength(255)]),
                    ])
                    ->columnSpan(1)
                    ->disabledOn('edit'),

                // Section for Document Uploads and Signature
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
                                    ->disabledOn('edit')
                                    ->maxSize(2048),
                                FileUpload::make('dokumen_pernyataan_keberatan_atas_permohonan_informasi_path')
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
                                ViewField::make('tanda_tangan')
                                    ->disabledOn('edit')
                                    ->view('components.signature-display') // Custom view untuk menampilkan gambar base64
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(2),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([Tables\Columns\TextColumn::make('created_at')->label('Tanggal Pengisian')->dateTime()->sortable(), Tables\Columns\TextColumn::make('nama_lengkap')->searchable(), Tables\Columns\TextColumn::make('pekerjaan')->searchable(), Tables\Columns\TextColumn::make('no_hp')->searchable(), Tables\Columns\TextColumn::make('email')->searchable(), Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make(),Tables\Actions\ViewAction::make()])
            ->headerActions([
                ExportAction::make()
                    ->exporter(FormPengaduanExporter::class)
                    ->label('Export')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary'),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFormPengaduans::route('/'),
            'create' => Pages\CreateFormPengaduan::route('/create'),
            'view' => Pages\ViewFormPengaduan::route('/{record}'),
            'edit' => Pages\EditFormPengaduan::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->hasAnyRole('admin','petugas_pst');
    }

    public static function authorizeResource(?string $resource = null): bool
    {
        return auth()->user()->hasAnyRole('admin','petugas_pst');
    }
}
