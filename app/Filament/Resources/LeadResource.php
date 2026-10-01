<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    protected static ?string $navigationGroup = 'Website Content';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Contact leads';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('name')->required()->disabled(),
                Forms\Components\TextInput::make('email')->email()->disabled(),
                Forms\Components\TextInput::make('phone')->tel()->disabled(),
                Forms\Components\TextInput::make('service_interested')->disabled(),
            ]),
            Forms\Components\Textarea::make('message')->rows(4)->disabled()->columnSpanFull(),
            Forms\Components\Select::make('status')
                ->options([
                    Lead::STATUS_NEW => 'New',
                    Lead::STATUS_CONTACTED => 'Contacted',
                    Lead::STATUS_CLOSED => 'Closed',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable()->placeholder('—'),
                Tables\Columns\TextColumn::make('phone')->placeholder('—'),
                Tables\Columns\TextColumn::make('service_interested')->placeholder('—')->label('Interested in'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        Lead::STATUS_NEW => 'danger',
                        Lead::STATUS_CONTACTED => 'warning',
                        Lead::STATUS_CLOSED => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->since()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    Lead::STATUS_NEW => 'New',
                    Lead::STATUS_CONTACTED => 'Contacted',
                    Lead::STATUS_CLOSED => 'Closed',
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLeads::route('/'),
        ];
    }
}
