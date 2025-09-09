<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('SEO')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('seo_title')
                                ->label('SEO Title')
                                ->maxLength(60),
                            TextInput::make('seo_keywords')
                                ->label('SEO Keywords')
                                ->helperText('Comma-separated keywords')
                                ->maxLength(255),
                        ]),
                        Textarea::make('seo_description')
                            ->label('SEO Description')
                            ->rows(3)
                            ->maxLength(160),
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

                Section::make('Slider')
                    ->schema([
                        FileUpload::make('slider_images')
                            ->label('Slider Images')
                            ->image()
                            ->multiple()
                            ->maxFiles(5)
                            ->imagePreviewHeight('110px')
                            ->enableReordering()
                            ->directory('site/sliders')
                            ->disk('public')
                            ->imageEditor()
                            ->helperText('Upload multiple images. Drag to reorder.'),
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

                Section::make('Publishing')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('handle')
                                ->label('Handle')
                                ->maxLength(100)
                                ->helperText('Public handle for portfolio URLs (site-wide).'),
                            \Filament\Forms\Components\Toggle::make('is_public')
                                ->label('Public')
                                ->default(true),
                        ]),
                    ]),
            ]);
    }
}
