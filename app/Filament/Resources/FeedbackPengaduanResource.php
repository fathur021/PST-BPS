<?php

namespace App\Filament\Resources;

use App\Filament\Exports\FeedbackPengaduanExporter;
use App\Filament\Resources\FeedbackPengaduanResource\Pages;
use App\Filament\Resources\FeedbackPengaduanResource\RelationManagers;
use App\Models\FeedbackPengaduan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeedbackPengaduanResource extends Resource
{
    protected static ?string $model = FeedbackPengaduan::class;

    protected static ?string $navigationLabel = 'Feedback Pengaduan';

    protected static ?string $modelLabel = 'List Feedback Pengaduan';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Pengaduan';
    
    protected static ?int $navigationSort = 6;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_lengkap')
                    ->maxLength(255),
                Forms\Components\Select::make('petugas_pengaduan')
                    ->relationship('petugasPengaduan', 'name')
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('kepuasan_petugas_pengaduan')
                    ->numeric(),
                Forms\Components\TextInput::make('kepuasan_sarana_prasarana_pengaduan')
                    ->numeric(),
                Forms\Components\Textarea::make('kritik_saran')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('petugasPengaduan.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kepuasan_petugas_pengaduan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kepuasan_sarana_prasarana_pengaduan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->headerActions([
                ExportAction::make()
                    ->exporter(FeedbackPengaduanExporter::class)
                    ->label('Export')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary'),
            ]);
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
            'index' => Pages\ListFeedbackPengaduans::route('/'),
            'create' => Pages\CreateFeedbackPengaduan::route('/create'),
            'view' => Pages\ViewFeedbackPengaduan::route('/{record}'),
            'edit' => Pages\EditFeedbackPengaduan::route('/{record}/edit'),
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
