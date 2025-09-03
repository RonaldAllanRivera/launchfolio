<?php

namespace App\Filament\Resources\Certifications\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use App\Models\Profile;

class CertificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Details')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('profile_id')
                                ->label('Profile')
                                ->relationship('profile', 'id')
                                ->searchable()
                                ->preload()
                                ->getOptionLabelFromRecordUsing(fn (Profile $record) => ($record->full_name ?: $record->handle ?: ('#'.$record->id))),
                            TextInput::make('title')->required()->maxLength(255),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('issuer')->maxLength(255),
                            DatePicker::make('issued_on')->native(false),
                        ]),
                    ]),

                Section::make('Files & Publish')
                    ->schema([
                        Grid::make(2)->schema([
                            FileUpload::make('image_path')->image()->directory('certifications')->disk('public')->imageEditor(),
                            FileUpload::make('pdf_path')->acceptedFileTypes(['application/pdf'])->directory('certifications')->disk('public'),
                        ]),
                        Grid::make(3)->schema([
                            Toggle::make('is_published')->label('Published')->default(true),
                            TextInput::make('sort_order')->numeric()->default(0),
                        ]),
                    ]),
            ]);
    }
}
