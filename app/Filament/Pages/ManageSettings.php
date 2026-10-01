<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

/**
 * A single, friendly form for every piece of business information that's
 * repeated across the site (phone, address, hours, socials, financing
 * links...) instead of a raw key/value CRUD table.
 */
class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Website Content';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?int $navigationSort = 4;

    protected static string $view = 'filament.pages.manage-settings';

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(): void
    {
        $this->form->fill(Setting::allCached());
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Forms\Components\Section::make('Business info')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('company_name'),
                        Forms\Components\TextInput::make('tagline'),
                        Forms\Components\FileUpload::make('logo_path')
                            ->label('Logo')
                            ->image()
                            ->directory('branding')
                            ->imageEditor()
                            ->helperText('Leave empty to show the company name as text in the header.'),
                        Forms\Components\TextInput::make('phone')->tel()->required(),
                        Forms\Components\TextInput::make('email')->email(),
                    ]),

                Forms\Components\Section::make('Address')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('address_line1')->label('Street address')->columnSpan(3),
                        Forms\Components\TextInput::make('address_city')->label('City'),
                        Forms\Components\TextInput::make('address_state')->label('State'),
                        Forms\Components\TextInput::make('address_zip')->label('ZIP'),
                    ]),

                Forms\Components\Section::make('Hours')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('hours_weekday')->helperText('e.g. Mon - Fri: 8:00 AM - 7:00 PM'),
                        Forms\Components\TextInput::make('hours_saturday')->helperText('e.g. Sat: 8:00 AM - 6:00 PM'),
                    ]),

                Forms\Components\Section::make('Links')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('facebook_url')->url(),
                        Forms\Components\TextInput::make('google_maps_url')->url()->label('Google Maps / directions URL'),
                        Forms\Components\TextInput::make('google_reviews_url')->url()->label('Google reviews badge URL'),
                        Forms\Components\TextInput::make('google_maps_embed_url')->url()->label('Google Maps embed URL (iframe src)'),
                        Forms\Components\TextInput::make('google_maps_location_embed_url')->url()->label('Google Maps location pin embed URL (Contact page)'),
                        Forms\Components\TextInput::make('snap_finance_url')->url()->label('Snap Finance URL'),
                        Forms\Components\TextInput::make('acima_finance_url')->url()->label('Acima Lease URL'),
                    ]),

                Forms\Components\Section::make('Sitewide background')
                    ->description('Shows behind every page that doesn\'t set its own background override (edit an individual page\'s "Background" tab to override it there instead).')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('site_background_type')
                            ->label('Background')
                            ->options([
                                'none' => 'None (plain white)',
                                'color' => 'Solid color',
                                'image' => 'Image',
                                'video' => 'Video',
                            ])
                            ->default('none')
                            ->required()
                            ->live()
                            ->columnSpanFull(),

                        Forms\Components\ColorPicker::make('site_background_color')
                            ->visible(fn(Forms\Get $get) => $get('site_background_type') === 'color'),

                        Forms\Components\FileUpload::make('site_background_image')
                            ->image()
                            ->directory('branding')
                            ->visible(fn(Forms\Get $get) => $get('site_background_type') === 'image')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('site_background_video')
                            ->acceptedFileTypes(['video/mp4', 'video/webm'])
                            ->directory('branding')
                            ->visible(fn(Forms\Get $get) => $get('site_background_type') === 'video')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('site_background_overlay')
                            ->label('Dark overlay (%)')
                            ->numeric()->minValue(0)->maxValue(100)->default(0)
                            ->visible(fn(Forms\Get $get) => in_array($get('site_background_type'), ['image', 'video'], true))
                            ->helperText('Darkens the image/video so page content stays readable.'),
                    ]),
            ]);
    }

    public function save(): void
    {
        collect($this->form->getState())
            ->each(function (mixed $value, string $key) {
                Setting::set($key, is_bool($value) ? ($value ? '1' : '0') : $value);
            });

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }
}
