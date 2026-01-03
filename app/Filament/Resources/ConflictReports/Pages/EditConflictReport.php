<?php

namespace App\Filament\Resources\ConflictReports\Pages;

use App\Filament\Resources\ConflictReports\ConflictReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditConflictReport extends EditRecord
{
    protected static string $resource = ConflictReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
