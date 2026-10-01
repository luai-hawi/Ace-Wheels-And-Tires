<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Website Content';

    protected static ?string $navigationLabel = 'Pages & Services';

    protected static ?int $navigationSort = 1;

    /** Lets the "Sections" relation manager appear as another tab alongside Details/Visibility/Background. */
    public static function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Page')
                ->columnSpanFull()
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Details')
                        ->schema([
                            Forms\Components\Section::make('Page details')
                                ->columns(2)
                                ->schema([
                                    Forms\Components\Select::make('type')
                                        ->label('Content type')
                                        ->options([
                                            Page::TYPE_PAGE => 'Standard page',
                                            Page::TYPE_SERVICE => 'Service',
                                            Page::TYPE_SERVICE_AREA => 'Service area',
                                            Page::TYPE_BLOG_POST => 'Blog post',
                                        ])
                                        ->default(Page::TYPE_PAGE)
                                        ->required()
                                        ->live(),

                                    Forms\Components\Select::make('parent_id')
                                        ->label('Group under')
                                        ->relationship('parent', 'title')
                                        ->searchable()
                                        ->preload()
                                        ->helperText('E.g. group a service under "Our Services", or a city under "Areas We Serve".'),

                                    Forms\Components\TextInput::make('title')
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function (string $operation, $state, Forms\Set $set, $get) {
                                            if ($operation === 'create' && blank($get('slug'))) {
                                                $set('slug', Str::slug($state));
                                            }
                                        }),

                                    Forms\Components\TextInput::make('slug')
                                        ->required()
                                        ->unique(ignoreRecord: true)
                                        ->helperText('Used in the page URL, e.g. /tire-sales'),

                                    Forms\Components\Textarea::make('excerpt')
                                        ->columnSpanFull()
                                        ->rows(2)
                                        ->helperText('Short description shown on cards, menus, and as a fallback SEO description.'),

                                    Forms\Components\FileUpload::make('featured_image')
                                        ->image()
                                        ->directory('pages')
                                        ->imageEditor()
                                        ->columnSpanFull()
                                        ->helperText('Leave empty to show a placeholder image on the site.'),

                                    Forms\Components\TextInput::make('icon')
                                        ->helperText('Optional heroicon name, e.g. heroicon-o-wrench-screwdriver'),
                                ]),
                        ]),

                    Forms\Components\Tabs\Tab::make('Visibility & SEO')
                        ->schema([
                            Forms\Components\Section::make('Visibility & navigation')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\Toggle::make('is_published')
                                        ->label('Published')
                                        ->default(true),

                                    Forms\Components\Toggle::make('show_in_menu')
                                        ->label('Show in main menu'),

                                    Forms\Components\TextInput::make('menu_order')
                                        ->numeric()
                                        ->default(0),

                                    Forms\Components\DateTimePicker::make('published_at')
                                        ->label('Publish date')
                                        ->helperText('Used to order blog posts / service areas.'),
                                ]),

                            Forms\Components\Section::make('SEO')
                                ->columns(1)
                                ->collapsed()
                                ->schema([
                                    Forms\Components\TextInput::make('meta_title'),
                                    Forms\Components\Textarea::make('meta_description')->rows(2),
                                ]),
                        ]),

                    Forms\Components\Tabs\Tab::make('Background')
                        ->schema([
                            Forms\Components\Section::make('Whole-page background')
                                ->description('Overrides the sitewide default background (Site Settings) just for this page.')
                                ->columns(2)
                                ->schema([
                                    Forms\Components\Select::make('background_type')
                                        ->label('Background')
                                        ->options([
                                            'default' => 'Use sitewide default',
                                            'none' => 'None (plain white)',
                                            'color' => 'Solid color',
                                            'image' => 'Image',
                                            'video' => 'Video',
                                        ])
                                        ->default('default')
                                        ->required()
                                        ->live()
                                        ->columnSpanFull(),

                                    Forms\Components\ColorPicker::make('background_color')
                                        ->visible(fn(Forms\Get $get) => $get('background_type') === 'color'),

                                    Forms\Components\FileUpload::make('background_image')
                                        ->image()
                                        ->directory('pages/backgrounds')
                                        ->visible(fn(Forms\Get $get) => $get('background_type') === 'image')
                                        ->columnSpanFull(),

                                    Forms\Components\FileUpload::make('background_video')
                                        ->label('Background video')
                                        ->acceptedFileTypes(['video/mp4', 'video/webm'])
                                        ->directory('pages/backgrounds')
                                        ->visible(fn(Forms\Get $get) => $get('background_type') === 'video')
                                        ->helperText('Short, muted, looping clips work best (a few seconds).')
                                        ->columnSpanFull(),

                                    Forms\Components\Grid::make(3)
                                        ->visible(fn(Forms\Get $get) => in_array($get('background_type'), ['image', 'video'], true))
                                        ->schema([
                                            Forms\Components\Select::make('background_size')
                                                ->options(Section::BACKGROUND_SIZES)
                                                ->default('cover'),
                                            Forms\Components\Select::make('background_position')
                                                ->options(Section::BACKGROUND_POSITIONS)
                                                ->default('center'),
                                            Forms\Components\TextInput::make('background_overlay')
                                                ->label('Dark overlay (%)')
                                                ->numeric()
                                                ->minValue(0)
                                                ->maxValue(100)
                                                ->default(0)
                                                ->helperText('Darkens the background so text stays readable.'),
                                        ]),
                                ]),
                        ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        Page::TYPE_PAGE => 'gray',
                        Page::TYPE_SERVICE => 'info',
                        Page::TYPE_SERVICE_AREA => 'success',
                        Page::TYPE_BLOG_POST => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->description(fn(Page $record): string => '/' . $record->slug)
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')->boolean()->label('Published'),
                Tables\Columns\IconColumn::make('show_in_menu')->boolean()->label('In menu'),
                Tables\Columns\TextColumn::make('menu_order')->sortable(),
                Tables\Columns\TextColumn::make('sections_count')
                    ->counts('sections')
                    ->label('Sections'),
                Tables\Columns\TextColumn::make('updated_at')->since()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')->options([
                    Page::TYPE_PAGE => 'Standard page',
                    Page::TYPE_SERVICE => 'Service',
                    Page::TYPE_SERVICE_AREA => 'Service area',
                    Page::TYPE_BLOG_POST => 'Blog post',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('menu_order');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SectionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
