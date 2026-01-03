<?php

namespace App\Filament\Resources\ConflictReports\Pages;

use App\Filament\Resources\ConflictReports\ConflictReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListConflictReports extends ListRecords
{
    protected static string $resource = ConflictReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
