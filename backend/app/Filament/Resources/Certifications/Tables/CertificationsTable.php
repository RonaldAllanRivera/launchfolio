<?php

namespace App\Filament\Resources\Certifications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class CertificationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')->label('Badge')->circular()->toggleable(),
                TextColumn::make('profile.full_name')->label('Profile')->toggleable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('issuer')->sortable()->toggleable(),
                TextColumn::make('issued_on')->date('Y-m-d')->sortable()->label('Issued'),
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
