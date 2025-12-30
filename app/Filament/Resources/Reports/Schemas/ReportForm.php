<?php

namespace App\Filament\Resources\Reports\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class ReportForm
{
    public static function configure(Schema $schema): Schema

    // -----------------------TESTING CODE BELOW FOR DB SEVER SIDE INTERACTION-----------------------
    {
                    // $results = DB::connection('sqlsrv_lsms')->select('EXEC uspGetEoTDipsuteType');
                    // dd($results);
                    
// -----------------------TESTING CODE ABOVE FOR DB SEVER SIDE INTERACTION-----------------------


        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Report Configuration')
                    ->description('Define your report title and select columns to include')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextInput::make('title')
                            ->label('Report Title')
                            ->required()
                            ->placeholder('Enter a descriptive title for this report')
                            ->maxLength(255),

                        \Filament\Forms\Components\CheckboxList::make('columns')
                            ->label('Select Columns')
                            ->options([
                                'reg_no' => 'Registration No',
                                'name' => 'Name',
                                'licence_no' => 'Licence No',
                                        'status' => 'Status',
                                'approved_date' => 'Approved Date',
                                'licence_expiry_date' => 'Licence Expiry Date',
                                'region' => 'Region',
                                'district' => 'District',
                                'email' => 'Email',
                                'phone' => 'Phone',
                                'paid' => 'Paid Status',
                            ])
                            ->columns(3)
                            ->gridDirection('row')
                            ->required()
                            ->helperText('Select at least one column to include in your report'),
                    ]),

                \Filament\Schemas\Components\Section::make('Filter Criteria')
                    ->description('Define the criteria to filter legal aid providers for this report')
                    ->icon('heroicon-o-funnel')
                    ->collapsible()
                    ->schema([
                        // Text Search Filters
                        \Filament\Schemas\Components\Section::make('Text Search')
                            ->description('Search by name or email')
                            ->compact()
                            ->schema([
                                \Filament\Schemas\Components\Grid::make(2)
                                    ->schema([
                                        \Filament\Forms\Components\TextInput::make('filters.name')
                                            ->label('Name')
                                            ->placeholder('Search by provider name...'),
                                        \Filament\Forms\Components\TextInput::make('filters.email')
                                            ->label('Email')
                                            ->placeholder('Search by email address...'),
                                    ]),
                            ]),

                        // Location Filters
                        \Filament\Schemas\Components\Section::make('Location')
                            ->description('Filter by geographic location')
                            ->compact()
                            ->schema([
                                \Filament\Schemas\Components\Grid::make(2)
                                    ->schema([
                                        \Filament\Forms\Components\Radio::make('filters.region_scope')
                                            ->label('Region Scope')
                                            ->options([
                                                'all' => 'All Regions',
                                                'specific' => 'Specific Region',
                                            ])
                                            ->default('all')
                                            ->inline()
                                            ->live(),
                                        \Filament\Forms\Components\Select::make('filters.region')
                                            ->label('Select Region')
                                            ->options(fn () => cache()->remember('legal_aid_regions', 60 * 60, function () {
                                                return \App\Models\LegalAidProvider::distinct()->orderBy('region')->pluck('region', 'region')->filter()->toArray();
                                            }))
                                            ->searchable()
                                            ->placeholder('Choose a region...')
                                            ->visible(fn ($get) => $get('filters.region_scope') === 'specific'),
                                    ]),

                                \Filament\Schemas\Components\Grid::make(2)
                                    ->schema([
                                        \Filament\Forms\Components\Radio::make('filters.district_scope')
                                            ->label('District Scope')
                                            ->options([
                                                'all' => 'All Districts',
                                                'specific' => 'Specific District',
                                            ])
                                            ->default('all')
                                            ->inline()
                                            ->live(),
                                        \Filament\Forms\Components\Select::make('filters.district')
                                            ->label('Select District')
                                            ->options(fn () => cache()->remember('legal_aid_districts', 60 * 60, function () {
                                                return \App\Models\LegalAidProvider::distinct()->orderBy('district')->pluck('district', 'district')->filter()->toArray();
                                            }))
                                            ->searchable()
                                            ->placeholder('Choose a district...')
                                            ->visible(fn ($get) => $get('filters.district_scope') === 'specific'),
                                    ]),
                            ]),

                        // Payment Status Filter
                        \Filament\Schemas\Components\Section::make('Payment Status')
                            ->description('Filter by payment status')
                            ->compact()
                            ->schema([
                                \Filament\Schemas\Components\Grid::make(2)
                                    ->schema([
                                        \Filament\Forms\Components\Radio::make('filters.paid_scope')
                                            ->label('Payment Scope')
                                            ->options([
                                                'all' => 'All Statuses',
                                                'specific' => 'Specific Status',
                                            ])
                                            ->default('all')
                                            ->inline()
                                            ->live(),
                                        \Filament\Forms\Components\Select::make('filters.paid')
                                            ->label('Payment Status')
                                            ->options([
                                                true => 'Paid',
                                                false => 'Unpaid',
                                            ])
                                            ->placeholder('Choose status...')
                                            ->visible(fn ($get) => $get('filters.paid_scope') === 'specific'),
                                    ]),
                            ]),

                        // Active/Expired Status Filter
                        \Filament\Schemas\Components\Section::make('Status')
                            ->description('Filter by active or expired providers (based on approved date within 3 years)')
                            ->compact()
                            ->schema([
                                \Filament\Schemas\Components\Grid::make(1)
                                    ->schema([
                                        \Filament\Forms\Components\Select::make('filters.status')
                                            ->label('Provider Status')
                                            ->options([
                                                '' => 'Any',
                                                'active' => 'Active',
                                                'expired' => 'Expired',
                                            ])
                                            ->placeholder('Choose status...'),
                                    ]),
                            ]),

                        // Date Range Filters
                        \Filament\Schemas\Components\Section::make('Date Ranges')
                            ->description('Filter by approval and expiry dates')
                            ->compact()
                            ->schema([
                                \Filament\Schemas\Components\Grid::make(3)
                                    ->schema([
                                        \Filament\Forms\Components\Radio::make('filters.approved_date_scope')
                                            ->label('Approved Date')
                                            ->options([
                                                'all' => 'All Dates',
                                                'specific' => 'Date Range',
                                            ])
                                            ->default('all')
                                            ->inline()
                                            ->live(),
                                        \Filament\Forms\Components\DatePicker::make('filters.approved_date_from')
                                            ->label('From Date')
                                            ->placeholder('Start date')
                                            ->visible(fn ($get) => $get('filters.approved_date_scope') === 'specific'),
                                        \Filament\Forms\Components\DatePicker::make('filters.approved_date_to')
                                            ->label('To Date')
                                            ->placeholder('End date')
                                            ->visible(fn ($get) => $get('filters.approved_date_scope') === 'specific'),
                                    ]),

                                \Filament\Schemas\Components\Grid::make(3)
                                    ->schema([
                                        \Filament\Forms\Components\Radio::make('filters.licence_expiry_date_scope')
                                            ->label('Licence Expiry Date')
                                            ->options([
                                                'all' => 'All Dates',
                                                'specific' => 'Date Range',
                                            ])
                                            ->default('all')
                                            ->inline()
                                            ->live(),
                                        \Filament\Forms\Components\DatePicker::make('filters.licence_expiry_date_from')
                                            ->label('From Date')
                                            ->placeholder('Start date')
                                            ->visible(fn ($get) => $get('filters.licence_expiry_date_scope') === 'specific'),
                                        \Filament\Forms\Components\DatePicker::make('filters.licence_expiry_date_to')
                                            ->label('To Date')
                                            ->placeholder('End date')
                                            ->visible(fn ($get) => $get('filters.licence_expiry_date_scope') === 'specific'),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
