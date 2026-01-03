<?php

namespace App\Filament\Resources\LegalAidProviders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class LegalAidProvidersTable
{


    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reg_no')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('licence_no')
                    ->searchable()
                    ->sortable(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(function ($record) {
                        return $record->approved_date?->greaterThanOrEqualTo(now()->subYears(3)) ? 'active' : 'expired';
                    })
                    ->colors([
                        'success' => 'active',
                        'danger' => 'expired',
                    ]),
                TextColumn::make('approved_date')
                    ->date()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('licence_expiry_date')
                    ->date()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('region')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('district')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('paid')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'expired' => 'Expired',
                    ])
                    ->query(function ($query, $value) {
                        $query->filtered(['status' => $value]);
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultPaginationPageOption(25)
            ->paginationPageOptions([10, 25, 50])
            ->deferLoading()
            ->poll(null); // Disable auto-refresh
    }
}
