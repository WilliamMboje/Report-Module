<?php

namespace App\Filament\Resources\UserReports\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // -------------------------------
            // Report Configuration Section
            // -------------------------------
            Section::make('Report Configuration')
                ->description('Define your report title and select columns to include')
                ->columnSpan('full') // span the full width
                ->schema([
                    TextInput::make('title')
                        ->label('Report Title')
                        ->placeholder('Enter report title')
                        ->required()
                        ->maxLength(255),

                    CheckboxList::make('columns')
                        ->label('Select Columns')
                        ->options([
                            'FirstName' => 'First Name',
                            'LastName' => 'Last Name',
                            'Phone' => 'Phone',
                            'Email' => 'Email',
                            'RoleName' => 'Role Name',
                            'isBlocked' => 'Blocked Status',
                        ])
                        ->columns(3)
                        ->required()
                        ->helperText('Select at least one column to include in your report'),
                ]),

            // -------------------------------
            // Filter Criteria Section
            // -------------------------------
            Section::make('Filter Criteria')
                ->description('Define filters for your report')
                ->columns(4) // 4 columns per row, like col-md-3
                ->columnSpan('full') // span the full width

                ->schema([
                    TextInput::make('filters.FirstName')
                        ->label('First Name')
                        ->placeholder('Search by first name')
                        ->columnSpan(1), // takes 1 column out of 4

                    TextInput::make('filters.LastName')
                        ->label('Last Name')
                        ->placeholder('Search by last name')
                        ->columnSpan(1), // takes 1 column out of 4

                    TextInput::make('filters.Phone')
                        ->label('Phone')
                        ->placeholder('Search by phone')->columnSpan(1), // takes 1 column out of 4


                    TextInput::make('filters.Email')
                        ->label('Email')
                        ->placeholder('Search by email')
                        ->columnSpan(1), // takes 1 column out of 4

                    Select::make('filters.RoleName')
                        ->label('Role')
                        ->options([
                            'Admin' => 'Admin',
                            'User' => 'User',
                            'Guest' => 'Guest',
                        ])
                        ->placeholder('Select role'),

                    Select::make('filters.isBlocked')
                        ->label('Blocked Status')
                        ->options([
                            0 => 'Active',
                            1 => 'Blocked',
                        ])
                        ->placeholder('Select status'),
                ]),
        ]);

    }
}
