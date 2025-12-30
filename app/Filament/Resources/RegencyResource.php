<?php

namespace App\Filament\Resources;

use App\Filament\Exports\RegencyExporter;
use App\Filament\Imports\RegencyImporter;
use App\Filament\Resources\RegencyResource\Pages;
use App\Filament\Resources\RegencyResource\RelationManagers;
use App\Models\Regency;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegencyResource extends Resource
{
    protected static ?string $model = Regency::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Kabupaten/Kota';

    protected static ?string $modelLabel = 'List Kabupaten/Kota';

    protected static ?string $navigationGroup = 'State Management';

    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->numeric()
                    ->unique(ignoreRecord: true)->required(),
                Select::make('provinsi_id')->relationship('provinsi', 'name')->preload()->required()->native(false),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provinsi.name')->label('Province')->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Regency')
                    ->searchable(),
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
            ->actions([ActionGroup::make([ViewAction::make(),EditAction::make(), DeleteAction::make()])])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->headerActions([
                ImportAction::make()
                    ->importer(RegencyImporter::class)
                    ->icon('heroicon-o-arrow-up-tray')
                    ->label('Import')
                    ->color('warning'),
                ExportAction::make()
                    ->exporter(RegencyExporter::class)
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
            'index' => Pages\ListRegencies::route('/'),
            'create' => Pages\CreateRegency::route('/create'),
            'edit' => Pages\EditRegency::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public static function authorizeResource(?string $resource = null): bool
    {
        return auth()->user()->hasRole('admin');
    }
}
