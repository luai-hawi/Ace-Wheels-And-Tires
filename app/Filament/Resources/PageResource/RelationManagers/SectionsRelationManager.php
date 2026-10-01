<?php

namespace App\Filament\Resources\PageResource\RelationManagers;

use App\Models\Section;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';

    protected static ?string $title = 'Sections';

    // No Section/SectionItem policies exist in this single-admin app (the panel
    // login is the only gate that matters here), so skip the policy lookup that
    // would otherwise silently hide this whole tab if authorization is denied.
    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return true;
    }

    /** Visible (or type unknown yet) when the parent section's type is one of these. */
    private static function parentTypeIn(array $types): Closure
    {
        return function (Forms\Get $get) use ($types) {
            $parentType = $get('../../type');

            return $parentType === null || in_array($parentType, $types, true);
        };
    }

    /**
     * Same as parentTypeIn() but for fields that live at the SAME level as `type`
     * (i.e. not inside the items Repeater) — one less "../" hop.
     */
    private static function parentTypeInSelf(array $types): Closure
    {
        return fn(Forms\Get $get) => in_array($get('type'), $types, true);
    }

    private static function textStyleFields(string $part, string $label): Forms\Components\Component
    {
        return Forms\Components\Fieldset::make($label)
            ->columns(4)
            ->schema([
                Forms\Components\ColorPicker::make("text_styles.{$part}.color")->label('Color'),
                Forms\Components\Select::make("text_styles.{$part}.size")->label('Size')->options(\App\Models\Section::TEXT_SIZES),
                Forms\Components\Select::make("text_styles.{$part}.weight")->label('Weight')->options(\App\Models\Section::TEXT_WEIGHTS),
                Forms\Components\Select::make("text_styles.{$part}.align")->label('Alignment')->options(\App\Models\Section::TEXT_ALIGNS),
            ]);
    }

    public static function itemTextStyleFields(string $part, string $label): Forms\Components\Component
    {
        return Forms\Components\Fieldset::make($label)
            ->columns(4)
            ->schema([
                Forms\Components\ColorPicker::make("text_styles.{$part}.color")->label('Color'),
                Forms\Components\Select::make("text_styles.{$part}.size")->label('Size')->options(\App\Models\SectionItem::TEXT_SIZES),
                Forms\Components\Select::make("text_styles.{$part}.weight")->label('Weight')->options(\App\Models\SectionItem::TEXT_WEIGHTS),
                Forms\Components\Select::make("text_styles.{$part}.align")->label('Alignment')->options(\App\Models\SectionItem::TEXT_ALIGNS),
            ]);
    }

    public function form(Form $form): Form
    {
        // Types that render a section-level body / button / layout / items at all —
        // used to hide fields a given section type simply never displays.
        $usesBody = ['hero', 'richtext', 'card_grid', 'cta_banner'];
        $usesButton = ['hero', 'richtext', 'cta_banner'];
        $usesItems = ['richtext', 'card_grid', 'brand_logos', 'testimonial_slider', 'map_areas', 'faq_accordion', 'gallery'];
        $itemHasImage = ['richtext', 'card_grid', 'gallery', 'brand_logos', 'testimonial_slider'];
        $itemHasButtons = ['card_grid', 'brand_logos', 'map_areas', 'gallery'];

        return $form->schema([
            Forms\Components\Tabs::make('Section')
                ->columnSpanFull()
                ->persistTabInQueryString(false)
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Content')
                        ->icon('heroicon-o-pencil-square')
                        ->schema([
                            Forms\Components\Select::make('type')
                                ->options(Section::TYPES)
                                ->required()
                                ->live()
                                ->helperText('Decides which layout this section renders with. Fields below adjust automatically.')
                                ->columnSpanFull(),

                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('heading'),
                                Forms\Components\TextInput::make('subheading'),
                            ]),

                            Forms\Components\RichEditor::make('body')
                                ->visible(static::parentTypeInSelf($usesBody))
                                ->columnSpanFull()
                                ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'link']),

                            Forms\Components\Grid::make(2)
                                ->visible(static::parentTypeInSelf($usesButton))
                                ->schema([
                                    Forms\Components\TextInput::make('button_text'),
                                    Forms\Components\TextInput::make('button_url'),
                                ]),

                            Forms\Components\Select::make('layout')
                                ->options([
                                    'image-left' => 'Image on left',
                                    'image-right' => 'Image on right',
                                    'centered' => 'Centered, no image',
                                ])
                                ->visible(fn(Forms\Get $get) => $get('type') === 'richtext')
                                ->helperText('Only used by the text block section.'),
                        ]),

                    Forms\Components\Tabs\Tab::make('Look & feel')
                        ->icon('heroicon-o-paint-brush')
                        ->schema([
                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\Select::make('background')
                                    ->options(Section::BACKGROUNDS)
                                    ->default('light')
                                    ->required()
                                    ->live(),

                                Forms\Components\ColorPicker::make('background_color')
                                    ->visible(fn(Forms\Get $get) => $get('background') === 'custom'),

                                Forms\Components\ColorPicker::make('text_color')
                                    ->helperText('Overrides the automatic light/dark text color.'),

                                Forms\Components\Select::make('background_size')
                                    ->options(Section::BACKGROUND_SIZES)
                                    ->default('cover')
                                    ->visible(fn(Forms\Get $get) => $get('background') === 'image')
                                    ->helperText('Cover crops the image; Contain fits the whole image; Fill stretches it.'),

                                Forms\Components\Select::make('background_position')
                                    ->options(Section::BACKGROUND_POSITIONS)
                                    ->default('center')
                                    ->visible(fn(Forms\Get $get) => $get('background') === 'image'),

                                Forms\Components\Select::make('background_repeat')
                                    ->options(Section::BACKGROUND_REPEATS)
                                    ->default('no-repeat')
                                    ->visible(fn(Forms\Get $get) => $get('background') === 'image'),

                                Forms\Components\TextInput::make('background_overlay')
                                    ->label('Overlay opacity (%)')
                                    ->numeric()->minValue(0)->maxValue(100)->default(65)
                                    ->visible(fn(Forms\Get $get) => in_array($get('background'), ['image', 'video', 'transparent'], true))
                                    ->helperText('Darkens an image/video, or adds a soft gray layer over a transparent section.'),

                                Forms\Components\Select::make('size')
                                    ->label('Section size')
                                    ->options(Section::SIZES)
                                    ->default('')
                                    ->helperText('Overrides this section type\'s normal height/padding.'),

                                Forms\Components\TextInput::make('min_height')
                                    ->label('Custom height (px)')
                                    ->numeric()->minValue(0)
                                    ->suffix('px')
                                    ->helperText('Optional exact pixel height, on top of the size preset above.'),

                                Forms\Components\Select::make('animation')
                                    ->options([
                                        'fade-up' => 'Fade up',
                                        'fade-in' => 'Fade in',
                                        'zoom-in' => 'Zoom in',
                                        'none' => 'None',
                                    ])
                                    ->default('fade-up')
                                    ->required(),

                                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                                Forms\Components\Toggle::make('is_active')->default(true),
                            ]),

                            Forms\Components\FileUpload::make('background_image')
                                ->image()
                                ->directory('sections')
                                ->visible(fn(Forms\Get $get) => $get('background') === 'image')
                                ->columnSpanFull(),

                            Forms\Components\FileUpload::make('background_video')
                                ->acceptedFileTypes(['video/mp4', 'video/webm'])
                                ->directory('sections')
                                ->visible(fn(Forms\Get $get) => $get('background') === 'video')
                                ->helperText('Short, muted, looping clips work best (a few seconds).')
                                ->columnSpanFull(),
                        ]),

                    Forms\Components\Tabs\Tab::make('Text styling')
                        ->icon('heroicon-o-swatch')
                        ->schema([
                            static::textStyleFields('heading', 'Heading'),
                            static::textStyleFields('subheading', 'Subheading'),
                            static::textStyleFields('body', 'Body text')
                                ->visible(static::parentTypeInSelf($usesBody)),
                        ]),

                    Forms\Components\Tabs\Tab::make('Custom code')
                        ->icon('heroicon-o-code-bracket')
                        ->schema([
                            Forms\Components\Textarea::make('custom_html')
                                ->label('Hardcoded HTML / CSS / Tailwind')
                                ->rows(10)
                                ->extraInputAttributes(['style' => 'font-family: monospace; font-size: 13px;'])
                                ->helperText('Optional. Renders exactly as typed inside this section — plain CSS (e.g. inside a <style> tag) always works; Tailwind utility classes work if they\'re already used elsewhere on the site.')
                                ->columnSpanFull(),

                            Forms\Components\Select::make('custom_html_position')
                                ->label('Position')
                                ->options(['before' => 'Before the normal content', 'after' => 'After the normal content'])
                                ->default('after'),
                        ]),

                    Forms\Components\Tabs\Tab::make('Advanced')
                        ->icon('heroicon-o-wrench-screwdriver')
                        ->schema([
                            Forms\Components\KeyValue::make('data')
                                ->keyLabel('Setting')
                                ->valueLabel('Value')
                                ->reorderable(false)
                                ->helperText('Freeform values only some section types use — Map section: key "map_embed_url"; Text section: key "video_url" for an inline content video.')
                                ->columnSpanFull(),
                        ]),

                    Forms\Components\Tabs\Tab::make('Cards / items')
                        ->icon('heroicon-o-rectangle-stack')
                        ->visible(static::parentTypeInSelf($usesItems))
                        ->schema([
                            Forms\Components\Repeater::make('items')
                                ->relationship('items')
                                ->collapsed()
                                ->collapsible()
                                ->reorderableWithButtons()
                                ->itemLabel(fn(array $state): ?string => $state['heading'] ?? 'New card')
                                ->schema([
                                    Forms\Components\FileUpload::make('image_path')
                                        ->image()
                                        ->directory('section-items')
                                        ->imageEditor()
                                        ->visible(static::parentTypeIn($itemHasImage)),
                                    Forms\Components\TextInput::make('placeholder_key')
                                        ->visible(static::parentTypeIn($itemHasImage))
                                        ->helperText('Label shown on the placeholder image until a real photo is uploaded.'),
                                    Forms\Components\TextInput::make('icon')
                                        ->helperText('Optional heroicon name (e.g. heroicon-o-wrench-screwdriver), shown when no image is uploaded.'),
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\TextInput::make('heading'),
                                        Forms\Components\TextInput::make('subheading'),
                                    ]),
                                    Forms\Components\Textarea::make('body')->rows(3),
                                    Forms\Components\Grid::make(3)
                                        ->visible(static::parentTypeIn($itemHasButtons))
                                        ->schema([
                                            Forms\Components\TextInput::make('button_text'),
                                            Forms\Components\TextInput::make('button_url'),
                                            Forms\Components\TextInput::make('link_url')
                                                ->helperText('For logos/badges that just link out.'),
                                        ]),
                                    Forms\Components\Grid::make(3)->schema([
                                        Forms\Components\TextInput::make('rating')
                                            ->numeric()->minValue(1)->maxValue(5)
                                            ->visible(static::parentTypeIn(['testimonial_slider']))
                                            ->helperText('1-5, for testimonials.'),
                                        Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                                        Forms\Components\Toggle::make('is_active')->default(true),
                                    ]),

                                    Forms\Components\Section::make('Text styling')
                                        ->collapsed()
                                        ->schema([
                                            static::itemTextStyleFields('heading', 'Heading'),
                                            static::itemTextStyleFields('body', 'Body text'),
                                        ]),

                                    Forms\Components\Section::make('Custom code')
                                        ->collapsed()
                                        ->schema([
                                            Forms\Components\Textarea::make('custom_html')
                                                ->label('Hardcoded HTML / CSS / Tailwind')
                                                ->rows(6)
                                                ->extraInputAttributes(['style' => 'font-family: monospace; font-size: 13px;'])
                                                ->helperText('Renders exactly as typed, attached to this card.')
                                                ->columnSpanFull(),
                                            Forms\Components\Select::make('custom_html_position')
                                                ->label('Position')
                                                ->options(['before' => 'Before this card\'s content', 'after' => 'After this card\'s content'])
                                                ->default('after'),
                                        ]),
                                ]),
                        ]),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('heading')
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn(string $state) => Section::TYPES[$state] ?? $state),
                Tables\Columns\TextColumn::make('heading')->placeholder('—'),
                Tables\Columns\TextColumn::make('background')->badge(),
                Tables\Columns\TextColumn::make('items_count')->counts('items')->label('Cards'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
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
}
