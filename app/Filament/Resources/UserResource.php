<?php

namespace App\Filament\Resources;

use App\Filament\Exports\UserExporter;
use App\Filament\Imports\UserImporter;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\Widgets\UserOverview;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'User';

    protected static ?string $modelLabel = 'Users';

    protected static ?string $navigationIcon = 'heroicon-s-user';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Profil User')
                ->description('Put the user name details in.')
                ->schema([
                    Select::make('roles')->relationship('roles', 'name')->preload()->required()->native(false),
                    TextInput::make('name')->label('Username')->maxLength(255)->columnSpanFull(),
                    TextInput::make('email')->label('Email Address')->email()->unique(ignoreRecord: true)->required()->maxLength(255)->columnSpanFull(),
                    TextInput::make('password')->password()->same('confirm_password')->required(fn($context) => $context === 'create')->maxLength(20)->visibleOn('create'),
                    TextInput::make('confirm_password')->same('password')->password()->required(fn($context) => $context === 'create')->columns(1)->visibleOn('create'),
                    Select::make('gender')
                        ->label('Jenis Kelamin')
                        ->options([
                            'laki-laki' => 'Laki - Laki',
                            'perempuan' => 'Perempuan',
                        ])
                        ->native(false)
                        ->required(),
                    DatePicker::make('dob'),
                    FileUpload::make('avatar_url')->directory('avatars')->visibility('public')->maxSize(5120)->label('Avatar')->image()->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([ImageColumn::make('avatar_url')->label('')->square()->size(80), TextColumn::make('name')->label('Username')->searchable(), TextColumn::make('email')->label('Email Address')->searchable(), TextColumn::make('roles.name')->label('Roles'), TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true), TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(UserExporter::class)
                    ->label('Export')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary'),
                // ImportAction::make()
                //     ->importer(UserImporter::class)
            ])
            ->actions([ActionGroup::make([ViewAction::make(), EditAction::make(), DeleteAction::make()])])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getWidgets(): array
    {
        return [UserOverview::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
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
