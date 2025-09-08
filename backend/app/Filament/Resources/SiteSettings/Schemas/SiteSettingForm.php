<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Branding')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('site_name')->label('Site Name'),
                            TextInput::make('tagline')->label('Tagline'),
                        ]),
                    ]),

                Section::make('Hero')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('hero_title')->label('Title'),
                            TextInput::make('hero_subtitle')->label('Subtitle'),
                        ]),
                        FileUpload::make('hero_image')
                            ->image()
                            ->directory('site')
                            ->disk('public')
                            ->imageEditor(),
                    ]),

                Section::make('Assets')
                    ->schema([
                        Grid::make(2)->schema([
                            FileUpload::make('logo_path')->image()->directory('site')->disk('public'),
                            FileUpload::make('favicon_path')->image()->directory('site')->disk('public'),
                        ]),
                    ]),

                Section::make('Domains')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('primary_domain')
                                ->label('Primary Domain')
                                ->placeholder('app.yourdomain.com')
                                ->helperText('Default domain used for public URLs.'),
                            TextInput::make('custom_domain')
                                ->label('Custom Domain (optional)')
                                ->placeholder('yourbrand.com')
                                ->helperText('For SaaS: map a verified custom domain when available.'),
                        ]),
                    ]),
            ]);
    }
}
