<?php

namespace App\Filament\Resources\LegalAidProviders\Pages;

use App\Filament\Resources\LegalAidProviders\LegalAidProviderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLegalAidProvider extends EditRecord
{
    protected static string $resource = LegalAidProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
