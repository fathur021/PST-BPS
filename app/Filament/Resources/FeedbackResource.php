<?php

namespace App\Filament\Resources;

use App\Enum\StatusRequestEnum;
use App\Filament\Exports\FeedbackExporter;
use App\Filament\Imports\FeedbackImporter;
use App\Filament\Resources\FeedbackResource\Pages;
use App\Filament\Resources\FeedbackResource\RelationManagers;
use App\Filament\Resources\FeedbackResource\Widgets\FeedbackOverview;
use App\Models\Feedback;
use App\Models\Request;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\UserRoleEnum;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;

    protected static ?string $navigationLabel = 'Feedback Buku Tamu';

    protected static ?string $modelLabel = 'List Feedback Buku Tamu';

    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';

    protected static ?string $navigationGroup = 'Buku Tamu';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama_lengkap')->required()->columnSpanFull(),
            Select::make('petugas_pst')
                ->relationship('petugasPst', 'name')
                ->native(false)
                ->required(),
            Select::make('front_office')
                ->relationship('frontOffice', 'name')
                ->native(false)
                ->required(),
            TextInput::make('kepuasan_petugas_pst')->required()->numeric()->maxValue(5)->minValue(0),
            TextInput::make('kepuasan_petugas_front_office')->required()->numeric()->maxValue(5)->minValue(0),
            TextInput::make('kepuasan_sarana_prasarana')->required()->numeric()->maxValue(5)->minValue(0),
            Textarea::make('kritik_saran')->columnSpanFull(),
        ])->disabled(fn() => auth()->user()->hasAnyRole('pst','front-office'));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_lengkap')->searchable()->sortable()->label('Nama Lengkap'),
                TextColumn::make('petugasPst.name')->searchable()->sortable()->label('Petugas PST'),
                TextColumn::make('kepuasan_petugas_pst')->searchable()->sortable()->label('Rating PST'),
                TextColumn::make('frontOffice.name')->searchable()->sortable()->label('Front Office'),
                TextColumn::make('kepuasan_petugas_front_office')->searchable()->sortable()->label('Rating Front Office'),
                TextColumn::make('kepuasan_sarana_prasarana')->searchable()->sortable()->label('Rating Sarana Prasarana'),
                TextColumn::make('created_at')->dateTime()->sortable()->label('Tanggal Pengisian'),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([ActionGroup::make([ViewAction::make(),EditAction::make(), DeleteAction::make()])])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->headerActions([
                ExportAction::make()
                    ->exporter(FeedbackExporter::class)
                    ->label('Export')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary'),
                // ImportAction::make()
                //     ->importer(FeedbackImporter::class)
            ])
            ->modifyQueryUsing(function (Builder $query) { 
                if (auth()->user()->hasRole('pst')) {
                    $userId = auth()->user()->id;
                    return $query->where('petugas_pst', $userId);
                }else if(auth()->user()->hasRole('front-office')){
                    $userId = auth()->user()->id;
                    return $query->where('front_office', $userId);
                }
            }) ;
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getWidgets(): array
    {
        return [FeedbackOverview::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeedback::route('/'),
            'create' => Pages\CreateFeedback::route('/create'),
            'edit' => Pages\EditFeedback::route('/{record}/edit'),
        ];
    }
}
