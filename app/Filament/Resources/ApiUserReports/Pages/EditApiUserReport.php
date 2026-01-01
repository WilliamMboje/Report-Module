<?php

namespace App\Filament\Resources\ApiUserReports\Pages;

use App\Filament\Resources\ApiUserReports\ApiUserReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditApiUserReport extends EditRecord
{
    protected static string $resource = ApiUserReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
