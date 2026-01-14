<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedbackResource\Pages;
use App\Filament\Resources\FeedbackResource\Widgets\FeedbackOverview;
use App\Models\Feedback;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
            TextInput::make('kepuasan_petugas_pst')
                ->required()
                ->numeric()
                ->minValue(0)
                ->maxValue(5),
            TextInput::make('kepuasan_petugas_front_office')
                ->required()
                ->numeric()
                ->minValue(0)
                ->maxValue(5),
            TextInput::make('kepuasan_sarana_prasarana')
                ->required()
                ->numeric()
                ->minValue(0)
                ->maxValue(5),
            Textarea::make('kritik_saran')->columnSpanFull(),
        ])->disabled(fn() => auth()->user()->hasAnyRole('pst', 'front-office'));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_lengkap')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Lengkap'),
                TextColumn::make('petugasPst.name')
                    ->searchable()
                    ->sortable()
                    ->label('Petugas PST'),
                TextColumn::make('kepuasan_petugas_pst')
                    ->searchable()
                    ->sortable()
                    ->label('Rating PST'),
                TextColumn::make('frontOffice.name')
                    ->searchable()
                    ->sortable()
                    ->label('Front Office'),
                TextColumn::make('kepuasan_petugas_front_office')
                    ->searchable()
                    ->sortable()
                    ->label('Rating Front Office'),
                TextColumn::make('kepuasan_sarana_prasarana')
                    ->searchable()
                    ->sortable()
                    ->label('Rating Sarana Prasarana'),
                TextColumn::make('kritik_saran')
                    ->label('Kritik & Saran')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),
                TextColumn::make('created_at')
                    ->dateTime('d-m-Y H:i:s')
                    ->sortable()
                    ->label('Tanggal Pengisian'),
                TextColumn::make('updated_at')
                    ->dateTime('d-m-Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(), 
                    DeleteAction::make()
                ])
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                ])
            ])
            ->headerActions([
                // Action custom untuk export CSV manual
                Action::make('export_csv')
                    ->label('Export CSV')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function () {
                        // Langsung panggil fungsi export manual
                        return \App\Filament\Exports\FeedbackExporter::export();
                    })
                    ->tooltip('Export data ke format CSV (Excel compatible)')
                    ->hidden(fn() => auth()->user()->hasAnyRole('pst', 'front-office')),
            ])
            ->modifyQueryUsing(function (Builder $query) { 
                $user = auth()->user();
                
                if ($user->hasRole('pst')) {
                    return $query->where('petugas_pst', $user->id);
                }
                
                if ($user->hasRole('front-office')) {
                    return $query->where('front_office', $user->id);
                }
                
                return $query;
            });
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