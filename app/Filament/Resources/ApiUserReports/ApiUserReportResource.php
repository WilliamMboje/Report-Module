<?php

namespace App\Filament\Resources\ApiUserReports;

use App\Filament\Resources\ApiUserReports\Pages\CreateApiUserReport;
use App\Filament\Resources\ApiUserReports\Pages\EditApiUserReport;
use App\Filament\Resources\ApiUserReports\Pages\ListApiUserReports;
use App\Filament\Resources\ApiUserReports\Pages\ViewApiUserReports;
use App\Filament\Resources\ApiUserReports\Schemas\ApiUserReportForm;
use App\Filament\Resources\ApiUserReports\Tables\ApiUserReportsTable;
use App\Models\ApiUserReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ApiUserReportResource extends Resource
{
    protected static ?string $model = ApiUserReport::class;
    protected static string|null|\UnitEnum $navigationGroup = 'Reports';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ApiUserReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApiUserReportsTable::configure($table);
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
            'index' => ListApiUserReports::route('/'),
            'create' => CreateApiUserReport::route('/create'),
            'view' => ViewApiUserReports::route('/{record}'),
            'edit' => EditApiUserReport::route('/{record}/edit'),
        ];
    }
}
