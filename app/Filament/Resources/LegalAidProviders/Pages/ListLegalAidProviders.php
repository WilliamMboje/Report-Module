<?php

namespace App\Filament\Resources\LegalAidProviders\Pages;

use App\Filament\Resources\LegalAidProviders\LegalAidProviderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLegalAidProviders extends ListRecords
{
    protected static string $resource = LegalAidProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
