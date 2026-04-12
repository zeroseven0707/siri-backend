<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeSectionResource\Pages;
use App\Models\FoodItem;
use App\Models\HomeSection;
use App\Models\HomeSectionItem;
use App\Models\Service;
use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomeSectionResource extends Resource
{
    protected static ?string $model = HomeSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';
    protected static ?string $navigationLabel = 'Home Sections';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 1;

    // ── Sync logic ────────────────────────────────────────────────────────
    public static function syncSection(HomeSection $section): int
    {
        $synced = 0;

        foreach ($section->items as $item) {
            $updated = match ($section->type) {
                'store_list' => static::syncStoreItem($item),
                'food_list'  => static::syncFoodItem($item),
                'service_list' => static::syncServiceItem($item),
                default      => false,
            };
            if ($updated) $synced++;
        }

        return $synced;
    }

    private static function syncStoreItem(HomeSectionItem $item): bool
    {
        $store = Store::where('slug', $item->action_value)->first();
        if (!$store) return false;

        $item->update([
            'title'    => $store->name,
            'subtitle' => $store->description,
            'image'    => $item->image ?: $store->image,
        ]);
        return true;
    }

    private static function syncFoodItem(HomeSectionItem $item): bool
    {
        $food = FoodItem::find($item->action_value);
        if (!$food) return false;

        $item->update([
            'title'    => $food->name,
            'subtitle' => 'Rp ' . number_format($food->price, 0, ',', '.'),
            'image'    => $item->image ?: $food->image,
        ]);
        return true;
    }

    private static function syncServiceItem(HomeSectionItem $item): bool
    {
        $service = Service::find($item->action_value);
        if (!$service) return false;

        $item->update([
            'title' => $service->name,
            'image' => $item->image ?: $service->icon,
        ]);
        return true;
    }

    // ── Form ──────────────────────────────────────────────────────────────
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
                            // Store picker
                            Forms\Components\Select::make('action_value')
                                ->label('Store')
                                ->options(Store::where('is_active', true)->pluck('name', 'slug'))
                                ->searchable()
                                ->visible(fn (Forms\Get $get): bool => $get('../../type') === 'store_list')
                                ->afterStateUpdated(function ($state, Forms\Set $set) {
                                    $store = Store::where('slug', $state)->first();
                                    if ($store) {
                                        $set('title', $store->name);
                                        $set('subtitle', $store->description);
                                        $set('image', $store->image);
                                        $set('action_type', 'store');
                                    }
                                })
                                ->live(),

                            // Food picker
                            Forms\Components\Select::make('action_value')
                                ->label('Food Item')
                                ->options(
                                    FoodItem::with('store')->where('is_available', true)->get()
                                        ->mapWithKeys(fn ($item) => [
                                            $item->id => "{$item->store->name} — {$item->name} (Rp " . number_format($item->price, 0, ',', '.') . ")"
                                        ])
                                )
                                ->searchable()
                                ->visible(fn (Forms\Get $get): bool => $get('../../type') === 'food_list')
                                ->afterStateUpdated(function ($state, Forms\Set $set) {
                                    $food = FoodItem::find($state);
                                    if ($food) {
                                        $set('title', $food->name);
                                        $set('subtitle', 'Rp ' . number_format($food->price, 0, ',', '.'));
                                        $set('image', $food->image);
                                        $set('action_type', 'food');
                                    }
                                })
                                ->live(),

                            // Service picker
                            Forms\Components\Select::make('action_value')
                                ->label('Service')
                                ->options(Service::where('is_active', true)->pluck('name', 'id'))
                                ->searchable()
                                ->visible(fn (Forms\Get $get): bool => $get('../../type') === 'service_list')
                                ->afterStateUpdated(function ($state, Forms\Set $set) {
                                    $service = Service::find($state);
                                    if ($service) {
                                        $set('title', $service->name);
                                        $set('image', $service->icon);
                                        $set('action_type', 'service');
                                    }
                                })
                                ->live(),

                            Forms\Components\TextInput::make('title')->maxLength(255),
                            Forms\Components\TextInput::make('subtitle'),
                            Forms\Components\TextInput::make('image')
                                ->url()->placeholder('https://...')->columnSpanFull(),

                            // Manual action fields untuk non-dynamic types
                            Forms\Components\Select::make('action_type')
                                ->options([
                                    'route'   => 'Route',
                                    'url'     => 'URL',
                                    'store'   => 'Store',
                                    'food'    => 'Food',
                                    'service' => 'Service',
                                ])
                                ->visible(fn (Forms\Get $get): bool =>
                                    !in_array($get('../../type'), ['store_list', 'food_list', 'service_list'])),
                            Forms\Components\TextInput::make('action_value')
                                ->maxLength(500)
                                ->visible(fn (Forms\Get $get): bool =>
                                    !in_array($get('../../type'), ['store_list', 'food_list', 'service_list'])),

                            Forms\Components\TextInput::make('order')->numeric()->default(0),
                            Forms\Components\Toggle::make('is_active')->default(true),
                        ])
                        ->columns(2)
                        ->orderColumn('order')
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                ]),
        ]);
    }

    // ── Table ─────────────────────────────────────────────────────────────
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')->sortable()->width(60),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('key')->badge()->color('gray'),
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
                    ->counts('items')->label('Items')->badge()->color('primary'),
                Tables\Columns\ToggleColumn::make('is_active'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime('d M Y')->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
            ])
            ->actions([
                Tables\Actions\Action::make('sync')
                    ->label('Sync')
                    ->icon('heroicon-o-arrow-path')
                    ->color('info')
                    ->visible(fn (HomeSection $record): bool =>
                        in_array($record->type, ['store_list', 'food_list', 'service_list']))
                    ->requiresConfirmation()
                    ->modalHeading('Sync Section Items')
                    ->modalDescription('Update semua item dari data terbaru di source table-nya.')
                    ->action(function (HomeSection $record) {
                        $record->load('items');
                        $synced = static::syncSection($record);
                        Notification::make()
                            ->title("Sync selesai — {$synced} item diperbarui")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('sync_selected')
                        ->label('Sync Selected')
                        ->icon('heroicon-o-arrow-path')
                        ->color('info')
                        ->requiresConfirmation()
                        ->action(function (\Illuminate\Support\Collection $records) {
                            $total = 0;
                            foreach ($records as $record) {
                                $record->load('items');
                                $total += static::syncSection($record);
                            }
                            Notification::make()
                                ->title("Sync selesai — {$total} item diperbarui")
                                ->success()
                                ->send();
                        }),
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
