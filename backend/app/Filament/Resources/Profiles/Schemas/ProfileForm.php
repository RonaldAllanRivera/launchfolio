<?php

namespace App\Filament\Resources\Profiles\Schemas;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User & Identity')
                    ->schema([
                        Grid::make(12)->schema([
                            Select::make('user_id')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->preload()
                                ->helperText('Associate this profile with a user account')
                                ->columnSpan(12),
                            TextInput::make('first_name')->label('First Name')->maxLength(100)->columnSpan(12),
                            TextInput::make('middle_initial')->label('Middle Name')->maxLength(100)->columnSpan(12),
                            TextInput::make('last_name')->label('Last Name')->maxLength(100)->columnSpan(12),
                        ]),
                    ]),
                    
                Section::make('Location & Links')
                    ->schema([
                        Grid::make(12)->schema([
                            TextInput::make('location_city')->label('City')->maxLength(120)->columnSpan(4),
                            Select::make('location_country')
                                ->label('Country')
                                ->options(fn () => (array) config('countries.list', []))
                                ->searchable()
                                ->getOptionLabelUsing(function ($value) {
                                    $list = (array) config('countries.list', []);
                                    return isset($list[$value]) ? (string) $list[$value] : null;
                                })
                                ->required()
                                ->rule(function () {
                                    $list = (array) config('countries.list', []);
                                    return Rule::in(array_keys($list));
                                })
                                ->reactive()
                                ->afterStateUpdated(function (Set $set) {
                                    $set('state_province', null);
                                })
                                ->columnSpan(4),
                            Select::make('state_province')
                                ->label('State/Province')
                                ->options(function (Get $get) {
                                    $country = $get('location_country');
                                    if (! $country) {
                                        return [];
                                    }
                                    $resolver = config('countries.states');
                                    if (is_object($resolver) && is_callable($resolver)) {
                                        return (array) $resolver($country);
                                    }
                                    return (array) (config('countries.states.' . $country) ?? []);
                                })
                                ->searchable()
                                ->disabled(fn (Get $get) => blank($get('location_country')))
                                ->required(function (Get $get) {
                                    $country = $get('location_country');
                                    if (! $country) return false;
                                    $resolver = config('countries.states');
                                    $options = [];
                                    if (is_object($resolver) && is_callable($resolver)) {
                                        $options = (array) $resolver($country);
                                    } else {
                                        $options = (array) (config('countries.states.' . $country) ?? []);
                                    }
                                    return ! empty($options);
                                })
                                ->rule(function (Get $get) {
                                    $country = $get('location_country');
                                    if (! $country) return null;
                                    $resolver = config('countries.states');
                                    $options = [];
                                    if (is_object($resolver) && is_callable($resolver)) {
                                        $options = (array) $resolver($country);
                                    } else {
                                        $options = (array) (config('countries.states.' . $country) ?? []);
                                    }
                                    if (empty($options)) return null;
                                    return Rule::in(array_keys($options));
                                })
                                ->columnSpan(4),
                            TextInput::make('industry')->label('Industry')->maxLength(120)->columnSpan(12),
                        ]),
                        Grid::make(12)->schema([
                            TextInput::make('website_url')->label('Website URL')->url()->maxLength(255)->columnSpan(12),
                            TextInput::make('linkedin_url')->label('LinkedIn URL')->url()->maxLength(255)->columnSpan(12),
                            TextInput::make('github_url')->label('GitHub URL')->url()->maxLength(255)->columnSpan(12),
                            TextInput::make('twitter_url')->label('X/Twitter URL')->url()->maxLength(255)->columnSpan(12),
                        ]),
                    ]),


                Section::make('Headline & Summary')
                    ->schema([
                        TextInput::make('headline')->label('Headline')->maxLength(255),
                        RichEditor::make('summary')->label('Summary')->columnSpanFull(),
                    ]),

                Section::make('Media')
                    ->schema([
                        Grid::make(1)->schema([
                            FileUpload::make('photo_path')->label('Photo')->image()->directory('profiles')->disk('public')->imageEditor(),
                        ]),
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
