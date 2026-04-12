<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeSectionResource\Pages;
use App\Models\HomeSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomeSectionResource extends Resource
{
    protected static ?string $model = HomeSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Home Sections';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('title')
                    ->required()->maxLength(255),
                Forms\Components\TextInput::make('key')
                    ->required()->maxLength(100)
                    ->unique(ignoreRecord: true)
                    ->helperText('Unique identifier, e.g. banner_promo'),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'banner'       => 'Banner',
                        'store_list'   => 'Store List',
                        'food_list'    => 'Food List',
                        'service_list' => 'Service List',
                        'promo'        => 'Promo',
                        'custom'       => 'Custom',
                    ]),
                Forms\Components\TextInput::make('order')
                    ->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ])->columns(2),

            Forms\Components\Section::make('Items')
                ->description('Manage items inside this section')
                ->schema([
                    Forms\Components\Repeater::make('items')
                        ->relationship()
                        ->schema([
                            Forms\Components\TextInput::make('title')->maxLength(255),
                            Forms\Components\TextInput::make('subtitle'),
                            Forms\Components\TextInput::make('image')
                                ->url()->placeholder('https://...')->columnSpanFull(),
                            Forms\Components\Select::make('action_type')
                                ->options([
                                    'route'   => 'Route',
                                    'url'     => 'URL',
                                    'store'   => 'Store',
                                    'food'    => 'Food',
                                    'service' => 'Service',
                                ]),
                            Forms\Components\TextInput::make('action_value')
                                ->maxLength(500),
                            Forms\Components\TextInput::make('order')
                                ->numeric()->default(0),
                            Forms\Components\Toggle::make('is_active')
                                ->default(true),
                        ])
                        ->columns(2)
                        ->orderColumn('order')
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->sortable()->width(60),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('key')
                    ->badge()->color('gray'),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'banner'       => 'warning',
                        'store_list'   => 'success',
                        'food_list'    => 'danger',
                        'service_list' => 'info',
                        'promo'        => 'primary',
                        default        => 'gray',
                    }),
                Tables\Columns\TextColumn::make('items_count')
                    ->counts('items')
                    ->label('Items')
                    ->badge()->color('primary'),
                Tables\Columns\ToggleColumn::make('is_active'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y')->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
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
            'index'  => Pages\ListHomeSections::route('/'),
            'create' => Pages\CreateHomeSection::route('/create'),
            'edit'   => Pages\EditHomeSection::route('/{record}/edit'),
        ];
    }
}
