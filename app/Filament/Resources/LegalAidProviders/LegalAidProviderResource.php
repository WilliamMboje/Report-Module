<?php

namespace App\Filament\Resources\LegalAidProviders;

use App\Filament\Resources\LegalAidProviders\Pages\CreateLegalAidProvider;
use App\Filament\Resources\LegalAidProviders\Pages\EditLegalAidProvider;
use App\Filament\Resources\LegalAidProviders\Pages\ListLegalAidProviders;
use App\Filament\Resources\LegalAidProviders\Pages\ViewLegalAidProvider;
use App\Filament\Resources\LegalAidProviders\Schemas\LegalAidProviderForm;
use App\Filament\Resources\LegalAidProviders\Schemas\LegalAidProviderInfolist;
use App\Filament\Resources\LegalAidProviders\Tables\LegalAidProvidersTable;
use App\Models\LegalAidProvider;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LegalAidProviderResource extends Resource
{
    protected static ?string $model = LegalAidProvider::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return LegalAidProviderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LegalAidProviderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LegalAidProvidersTable::configure($table);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->select([
                'id', 'reg_no', 'name', 'licence_no', 'approved_date', 
                'licence_expiry_date', 'region', 'district', 'email', 
                'phone', 'paid', 'created_at', 'updated_at'
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLegalAidProviders::route('/'),
            'create' => CreateLegalAidProvider::route('/create'),
            'view' => ViewLegalAidProvider::route('/{record}'),
            'edit' => EditLegalAidProvider::route('/{record}/edit'),
        ];
    }
}
