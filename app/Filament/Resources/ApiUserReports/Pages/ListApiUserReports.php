<?php

namespace App\Filament\Resources\ApiUserReports\Pages;

use App\Filament\Resources\ApiUserReports\ApiUserReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListApiUserReports extends ListRecords
{
    protected static string $resource = ApiUserReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
