<?php

namespace App\Filament\Resources\AwarenessReports\Pages;

use App\Filament\Resources\AwarenessReports\AwarenessReportResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ListRecords;

class ListAwarenessReports extends ListRecords
{
    protected static string $resource = AwarenessReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
