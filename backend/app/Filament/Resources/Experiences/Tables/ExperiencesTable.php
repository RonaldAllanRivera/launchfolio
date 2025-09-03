<?php

namespace App\Filament\Resources\Experiences\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ExperiencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('profile.full_name')->label('Profile')->toggleable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('company')->sortable()->toggleable(),
                TextColumn::make('start_date')->date('Y-m')->label('Start')->sortable()->toggleable(),
                TextColumn::make('end_date')->date('Y-m')->label('End')->sortable()->toggleable(),
                ToggleColumn::make('is_published')->label('Published')->sortable(),
                TextColumn::make('sort_order')->sortable()->label('Order'),
            ])
            ->filters([
                //
            ])
            ->reorderable('sort_order')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
