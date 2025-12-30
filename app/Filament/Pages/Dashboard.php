<?php
 
namespace App\Filament\Pages;

use App\Filament\Widgets\WelcomeWidget;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;
    // public function getWidgets(): array
    // {
    //     return [
    //         WelcomeWidget::class(),
    //     ];
    // }

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make('')->schema([
                DatePicker::make('startDate'),
                DatePicker::make('endDate'),
            ])->columns(2)
        ]);
    }

    // ...
}