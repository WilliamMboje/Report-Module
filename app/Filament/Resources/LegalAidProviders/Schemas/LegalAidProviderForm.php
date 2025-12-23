<?php

namespace App\Filament\Resources\LegalAidProviders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LegalAidProviderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reg_no')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('licence_no')
                    ->required(),
                DatePicker::make('approved_date')
                    ->required(),
                DatePicker::make('licence_expiry_date')
                    ->required(),
                TextInput::make('region')
                    ->required(),
                TextInput::make('district')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                Toggle::make('paid')
                    ->required(),
            ]);
    }
}
