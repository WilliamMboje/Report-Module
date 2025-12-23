<?php

namespace App\Filament\Resources\LegalAidProviders\Pages;

use App\Filament\Resources\LegalAidProviders\LegalAidProviderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLegalAidProvider extends ViewRecord
{
    protected static string $resource = LegalAidProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
