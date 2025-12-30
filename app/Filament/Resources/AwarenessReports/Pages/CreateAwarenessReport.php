<?php

namespace App\Filament\Resources\AwarenessReports\Pages;

use App\Filament\Resources\AwarenessReports\AwarenessReportResource;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Section;

class CreateAwarenessReport extends CreateRecord
{
//    protected static string $resource = AwarenessReportResource::class;

    protected static string $resource = AwarenessReportResource::class;


    //REDIRECT TO INDEX
    protected function getRedirectUrl(): string
    {
        // Use the static route name of the index page
        return AwarenessReportResource::getUrl('index');
    }

}




