<?php

namespace App\Filament\Resources\AwarenessReports\Pages;

use App\Filament\Resources\AwarenessReports\AwarenessReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAwarenessReport extends EditRecord
{
    protected static string $resource = AwarenessReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
