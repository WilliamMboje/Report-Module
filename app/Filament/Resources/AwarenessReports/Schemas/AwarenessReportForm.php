<?php

namespace App\Filament\Resources\AwarenessReports\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AwarenessReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Report Configuration')
                    ->description('Define your report title and select columns to include')
                    ->schema([
                        TextInput::make('title')
                            ->label('Report Title')
                            ->placeholder('Enter report title')
                            ->required()
                            ->maxLength(255),

                        CheckboxList::make('columns')
                            ->label('Select Columns')
                            ->options([
                                'Date' => 'Date',
                                'Maelezo' => 'Maelezo',
                                'Mwananchi' => 'Mwananchi',
                                'Aina' => 'Aina',
                                'Mkoa' => 'Mkoa',
                                'Hali' => 'Hali',
                            ])
                            ->columns(3)
                            ->required()
                            ->helperText('Select at least one column to include in your report'),
                    ]),

                Section::make('Filter Criteria')
                    ->description('Define filters for your report')
                    ->schema([
                        TextInput::make('filters.Mwananchi')
                            ->label('Mwananchi')
                            ->placeholder('Search by citizen'),

                        Select::make('filters.Aina')
                            ->label('Aina')
                            ->options([
                                'Seminar' => 'Seminar',
                                'Workshop' => 'Workshop',
                                'Campaign' => 'Campaign',
                            ])
                            ->placeholder('Choose type'),

                        Select::make('filters.Mkoa')
                            ->label('Mkoa')
                            ->options([
                                'Dar es Salaam' => 'Dar es Salaam',
                                'Arusha' => 'Arusha',
                                'Mwanza' => 'Mwanza',
                            ])
                            ->placeholder('Select an option'),

                        Select::make('filters.Hali')
                            ->label('Hali')
                            ->options([
                                'Active' => 'Active',
                                'Inactive' => 'Inactive',
                            ])
                            ->placeholder('Select an option'),
                    ]),
            ]);
    }
}
