<?php

namespace App\Filament\Resources\Profiles\Schemas;

use App\Models\User;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User & Identity')
                    ->schema([
                        Grid::make(3)->schema([
                            Select::make('user_id')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->preload()
                                ->helperText('Associate this profile with a user account'),
                            TextInput::make('first_name')->maxLength(100),
                            TextInput::make('last_name')->maxLength(100),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('handle')->maxLength(100)->helperText('Public handle for future portfolio URLs')->unique(ignoreRecord: true),
                            Toggle::make('is_public')->label('Public')->default(true),
                        ]),
                    ]),

                Section::make('Headline & Summary')
                    ->schema([
                        TextInput::make('headline')->maxLength(255),
                        RichEditor::make('summary')->columnSpanFull(),
                    ]),

                Section::make('Media')
                    ->schema([
                        Grid::make(2)->schema([
                            FileUpload::make('photo_path')->image()->directory('profiles')->disk('public')->imageEditor(),
                            FileUpload::make('banner_path')->image()->directory('profiles')->disk('public')->imageEditor(),
                        ]),
                    ]),

                Section::make('Location & Links')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('location_city')->maxLength(120),
                            TextInput::make('location_country')->maxLength(120),
                            TextInput::make('industry')->maxLength(120),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('website_url')->url()->maxLength(255),
                            TextInput::make('linkedin_url')->url()->maxLength(255),
                            TextInput::make('github_url')->url()->maxLength(255),
                            TextInput::make('twitter_url')->url()->maxLength(255),
                        ])->columns(4),
                    ]),

                Section::make('Contact')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('contact_email')->email()->maxLength(255),
                            TextInput::make('phone')->maxLength(50),
                        ]),
                    ]),
            ]);
    }
}
