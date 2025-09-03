<?php

namespace App\Filament\Resources\Experiences\Schemas;

use App\Models\Profile;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profile & Role')
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
                            TextInput::make('company')->maxLength(255),
                            TextInput::make('employment_type')->maxLength(100),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('location')->maxLength(255),
                            TextInput::make('location_type')->placeholder('On-site / Remote / Hybrid')->maxLength(50),
                        ]),
                    ]),

                Section::make('Dates & Visibility')
                    ->schema([
                        Grid::make(3)->schema([
                            DatePicker::make('start_date')->native(false),
                            DatePicker::make('end_date')->native(false),
                            Toggle::make('is_current')->label('Current Role'),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('sort_order')->numeric()->default(0),
                            Toggle::make('is_published')->label('Published')->default(true),
                        ]),
                    ]),

                Section::make('Description')
                    ->schema([
                        RichEditor::make('description')->columnSpanFull(),
                    ]),
            ]);
    }
}
