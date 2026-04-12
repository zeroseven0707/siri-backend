<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreResource\Pages;
use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StoreResource extends Resource
{
    protected static ?string $model = Store::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Store Info')->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                        $set('slug', \Illuminate\Support\Str::slug($state))),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('description')->rows(3)->columnSpanFull(),
                Forms\Components\TextInput::make('image')->url()->columnSpanFull(),
                Forms\Components\TextInput::make('address')->required()->maxLength(500)->columnSpanFull(),
                Forms\Components\TextInput::make('latitude')->numeric(),
                Forms\Components\TextInput::make('longitude')->numeric(),
                Forms\Components\Toggle::make('is_open')->default(true),
                Forms\Components\Toggle::make('is_active')->default(true),
            ])->columns(2),

            Forms\Components\Section::make('Food Items')->schema([
                Forms\Components\Repeater::make('foodItems')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('name')->required()->maxLength(255),
                        Forms\Components\TextInput::make('price')->numeric()->required()->prefix('Rp'),
                        Forms\Components\Textarea::make('description')->rows(2)->columnSpanFull(),
                        Forms\Components\TextInput::make('image')->url()->columnSpanFull(),
                        Forms\Components\Toggle::make('is_available')->default(true),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('owner.name')->label('Owner')->searchable(),
                Tables\Columns\TextColumn::make('address')->limit(40),
                Tables\Columns\TextColumn::make('food_items_count')->counts('foodItems')->label('Menu')->badge()->color('primary'),
                Tables\Columns\ToggleColumn::make('is_open')->label('Open'),
                Tables\Columns\ToggleColumn::make('is_active')->label('Active'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y')->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_open')->label('Open'),
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
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

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListStores::route('/'),
            'create' => Pages\CreateStore::route('/create'),
            'edit'   => Pages\EditStore::route('/{record}/edit'),
        ];
    }
}
