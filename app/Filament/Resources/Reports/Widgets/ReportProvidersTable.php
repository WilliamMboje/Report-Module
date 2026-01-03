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
                    $columns[] = Tables\Columns\TextColumn::make($column)
                        ->label('Status')
                        ->getStateUsing(function ($record) {
                            return $record->approved_date?->greaterThanOrEqualTo(now()->subYears(3)) ? 'active' : 'expired';
                        })
                        ->badge()
                        ->color(fn (string $state): string => $state === 'active' ? 'success' : 'danger');
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
                    $query->filtered($filters);
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
