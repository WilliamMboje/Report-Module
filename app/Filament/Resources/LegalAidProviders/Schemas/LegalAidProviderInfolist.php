<?php

namespace App\Filament\Resources\LegalAidProviders\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LegalAidProviderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('reg_no'),
                TextEntry::make('name'),
                TextEntry::make('licence_no'),
                TextEntry::make('approved_date')
                    ->date(),
                TextEntry::make('licence_expiry_date')
                    ->date(),
                TextEntry::make('region'),
                TextEntry::make('district'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('phone'),
                IconEntry::make('paid')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
