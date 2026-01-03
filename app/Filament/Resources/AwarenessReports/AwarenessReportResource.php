<?php

namespace App\Filament\Resources\AwarenessReports;

use App\Filament\Resources\AwarenessReports\Pages\CreateAwarenessReport;
use App\Filament\Resources\AwarenessReports\Pages\EditAwarenessReport;
use App\Filament\Resources\AwarenessReports\Pages\ListAwarenessReports;
use App\Filament\Resources\AwarenessReports\Schemas\AwarenessReportForm;
use App\Filament\Resources\AwarenessReports\Tables\AwarenessReportsTable;
use App\Models\AwarenessReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AwarenessReportResource extends Resource
{
    protected static ?string $model = AwarenessReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;


//    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Awareness Reports';

    protected static ?string $pluralLabel = 'Awareness Reports';

    protected static string|null|\UnitEnum $navigationGroup = 'Reports';

    public static function form(Schema $schema): Schema
    {
        return AwarenessReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AwarenessReportsTable::configure($table);
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
            'index' => ListAwarenessReports::route('/'),
            'create' => CreateAwarenessReport::route('/create'),
            'view' => Pages\ViewAwarenessReport::route('/{record}'), // 👈 REQUIRED
            'edit' => EditAwarenessReport::route('/{record}/edit'),
        ];
    }
}
