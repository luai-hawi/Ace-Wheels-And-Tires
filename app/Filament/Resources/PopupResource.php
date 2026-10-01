<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PopupResource\Pages;
use App\Models\Page;
use App\Models\Popup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PopupResource extends Resource
{
    protected static ?string $model = Popup::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Website Content';

    protected static ?string $navigationLabel = 'Popups & Widgets';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Popup')
                ->columnSpanFull()
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Content')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->helperText('For your reference only — visitors never see this.')
                                ->columnSpanFull(),

                            Forms\Components\Select::make('type')
                                ->label('What is this?')
                                ->options(Popup::TYPES)
                                ->default(Popup::TYPE_MODAL)
                                ->required()
                                ->live()
                                ->columnSpanFull(),

                            Forms\Components\Toggle::make('is_enabled')
                                ->label('Enabled (show on the site)')
                                ->columnSpanFull(),

                            Forms\Components\TextInput::make('heading'),
                            Forms\Components\TextInput::make('button_text'),

                            Forms\Components\Textarea::make('body')
                                ->rows(3)
                                ->columnSpanFull(),

                            Forms\Components\TextInput::make('button_url')
                                ->columnSpanFull(),

                            Forms\Components\FileUpload::make('image')
                                ->image()
                                ->directory('popups')
                                ->visible(fn(Forms\Get $get) => $get('type') === Popup::TYPE_MODAL)
                                ->helperText('Shown at the top of the center popup. Leave empty for a text-only popup.')
                                ->columnSpanFull(),
                        ]),

                    Forms\Components\Tabs\Tab::make('Appearance')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\ColorPicker::make('background_color')
                                    ->helperText('Leave empty for the default brand dark background.'),
                                Forms\Components\ColorPicker::make('text_color')
                                    ->helperText('Leave empty for white text.'),
                            ]),

                            Forms\Components\Select::make('position')
                                ->label('Side of the screen')
                                ->options(['left' => 'Left', 'right' => 'Right'])
                                ->default('right')
                                ->visible(fn(Forms\Get $get) => $get('type') === Popup::TYPE_SIDE_WIDGET),
                        ]),

                    Forms\Components\Tabs\Tab::make('Behavior')
                        ->schema([
                            Forms\Components\Grid::make(2)
                                ->visible(fn(Forms\Get $get) => $get('type') === Popup::TYPE_MODAL)
                                ->schema([
                                    Forms\Components\Select::make('trigger')
                                        ->label('Show it...')
                                        ->options(Popup::TRIGGERS)
                                        ->default('delay')
                                        ->required()
                                        ->live(),

                                    Forms\Components\TextInput::make('trigger_value')
                                        ->numeric()
                                        ->default(4)
                                        ->visible(fn(Forms\Get $get) => in_array($get('trigger'), ['delay', 'scroll_percent'], true))
                                        ->label(fn(Forms\Get $get) => $get('trigger') === 'scroll_percent' ? 'Scrolled down (%)' : 'Delay (seconds)'),
                                ]),

                            Forms\Components\Select::make('frequency')
                                ->label('How often')
                                ->options(Popup::FREQUENCIES)
                                ->default('once_per_session')
                                ->required()
                                ->visible(fn(Forms\Get $get) => $get('type') === Popup::TYPE_MODAL)
                                ->helperText('A side widget is always visible while it\'s enabled, so this only applies to center popups.'),

                            Forms\Components\Select::make('show_on')
                                ->label('Only show on these pages')
                                ->multiple()
                                ->options(fn() => Page::query()->orderBy('title')->pluck('title', 'slug'))
                                ->searchable()
                                ->helperText('Leave empty to show on every page.')
                                ->columnSpanFull(),

                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\DateTimePicker::make('starts_at')
                                    ->helperText('Leave empty to start immediately.'),
                                Forms\Components\DateTimePicker::make('ends_at')
                                    ->helperText('Leave empty to run indefinitely.'),
                            ]),

                            Forms\Components\TextInput::make('sort_order')
                                ->numeric()
                                ->default(0)
                                ->helperText('When more than one popup/widget could show at once, lower numbers go first.'),
                        ]),

                    Forms\Components\Tabs\Tab::make('Custom code')
                        ->schema([
                            Forms\Components\Textarea::make('custom_html')
                                ->label('Hardcoded HTML / CSS / Tailwind')
                                ->rows(8)
                                ->extraInputAttributes(['style' => 'font-family: monospace; font-size: 13px;'])
                                ->helperText('Optional. Anything you put here renders exactly as-is inside this popup — plain CSS always works; Tailwind utility classes work if they\'re already used elsewhere on the site.')
                                ->columnSpanFull(),

                            Forms\Components\Select::make('custom_html_position')
                                ->label('Position')
                                ->options(['before' => 'Before the normal content', 'after' => 'After the normal content'])
                                ->default('after'),
                        ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn(string $state) => Popup::TYPES[$state] ?? $state)
                    ->color(fn(string $state) => $state === Popup::TYPE_MODAL ? 'info' : 'success'),
                Tables\Columns\IconColumn::make('is_enabled')->boolean()->label('Enabled'),
                Tables\Columns\TextColumn::make('trigger')
                    ->formatStateUsing(fn(string $state) => Popup::TRIGGERS[$state] ?? $state),
                Tables\Columns\TextColumn::make('frequency')
                    ->formatStateUsing(fn(string $state) => Popup::FREQUENCIES[$state] ?? $state),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->since()->sortable(),
            ])
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPopups::route('/'),
            'create' => Pages\CreatePopup::route('/create'),
            'edit' => Pages\EditPopup::route('/{record}/edit'),
        ];
    }
}
