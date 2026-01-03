<?php

namespace App\Filament\Resources\ConflictReports;

use App\Filament\Resources\ConflictReports\Pages\CreateConflictReport;
use App\Filament\Resources\ConflictReports\Pages\EditConflictReport;
use App\Filament\Resources\ConflictReports\Pages\ListConflictReports;
use App\Filament\Resources\ConflictReports\Schemas\ConflictReportForm;
use App\Filament\Resources\ConflictReports\Tables\ConflictReportsTable;
use App\Models\ConflictReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ConflictReportResource extends Resource
{
    protected static ?string $model = ConflictReport::class;
    protected static string|null|\UnitEnum $navigationGroup = 'Reports';


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ConflictReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConflictReportsTable::configure($table);
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
            'index' => ListConflictReports::route('/'),
            'create' => CreateConflictReport::route('/create'),
            'edit' => EditConflictReport::route('/{record}/edit'),
        ];
    }
}
