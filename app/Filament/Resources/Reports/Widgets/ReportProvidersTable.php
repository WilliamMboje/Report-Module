<?php

namespace App\Filament\Resources\Reports\Widgets;

use App\Models\LegalAidProvider;
use App\Models\Report;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ReportProvidersTable extends BaseWidget
{
    // protected string $view = 'filament.resources.reports.widgets.report-providers-table'; // TableWidget handles view automatically usually, but let's keep it if needed or remove if standard. 
    // Actually TableWidget doesn't need a custom view unless we are customizing the wrapper. 
    // The error was about HasTable. TableWidget implements HasTable.
    
    public ?Report $record = null;

    public function table(Table $table): Table
    {
        $columns = [];
        
        // Add row index column
        $columns[] = Tables\Columns\TextColumn::make('index')
            ->label('#')
            ->rowIndex();

        if ($this->record && $selectedColumns = $this->record->columns) {
            foreach ($selectedColumns as $column) {
                if ($column === 'paid') {
                    $columns[] = Tables\Columns\TextColumn::make($column)
                        ->formatStateUsing(fn (bool $state): string => $state ? 'Paid' : 'Not Paid')
                        ->badge()
                        ->color(fn (bool $state): string => $state ? 'success' : 'danger');
                } elseif ($column === 'status') {
                    $columns[] = Tables\Columns\BadgeColumn::make($column)
                        ->label('Status')
                        ->getStateUsing(fn ($record) => $record->status)
                        ->colors([
                            'success' => 'active',
                            'danger' => 'expired',
                        ]);
                } else {
                    $columns[] = Tables\Columns\TextColumn::make($column);
                }
            }
        } else {
            // Default columns if none selected?
            $columns[] = Tables\Columns\TextColumn::make('name');
        }

        return $table
            ->query(function () {
                $query = LegalAidProvider::query();

                if ($this->record && $filters = $this->record->filters) {
                    if (! empty($filters['name'])) {
                        $query->where('name', 'like', "%{$filters['name']}%");
                    }
                    if (! empty($filters['email'])) {
                        $query->where('email', 'like', "%{$filters['email']}%");
                    }
                    
                    // Region Scope
                    if (isset($filters['region_scope']) && $filters['region_scope'] === 'specific' && ! empty($filters['region'])) {
                        $query->where('region', $filters['region']);
                    }

                    // District Scope
                    if (isset($filters['district_scope']) && $filters['district_scope'] === 'specific' && ! empty($filters['district'])) {
                        $query->where('district', $filters['district']);
                    }

                    // Paid Scope
                    if (isset($filters['paid_scope']) && $filters['paid_scope'] === 'specific' && isset($filters['paid'])) {
                        $query->where('paid', $filters['paid']);
                    } elseif (isset($filters['paid']) && !isset($filters['paid_scope'])) {
                         $query->where('paid', $filters['paid']);
                    }

                    // Approved Date Scope
                    if (isset($filters['approved_date_scope']) && $filters['approved_date_scope'] === 'specific') {
                        if (!empty($filters['approved_date_from'])) {
                            $query->whereDate('approved_date', '>=', $filters['approved_date_from']);
                        }
                        if (!empty($filters['approved_date_to'])) {
                            $query->whereDate('approved_date', '<=', $filters['approved_date_to']);
                        }
                    }

                    // Licence Expiry Date Scope
                    if (isset($filters['licence_expiry_date_scope']) && $filters['licence_expiry_date_scope'] === 'specific') {
                        if (!empty($filters['licence_expiry_date_from'])) {
                            $query->whereDate('licence_expiry_date', '>=', $filters['licence_expiry_date_from']);
                        }
                        if (!empty($filters['licence_expiry_date_to'])) {
                            $query->whereDate('licence_expiry_date', '<=', $filters['licence_expiry_date_to']);
                        }
                    }
                } else {
                    // If no record or filters, maybe return empty or all?
                    // Let's return empty if no record to be safe, or all if just no filters.
                    if (! $this->record) {
                        return $query->whereRaw('1 = 0');
                    }
                }

                return $query;
            })
            ->columns($columns);
    }
}
