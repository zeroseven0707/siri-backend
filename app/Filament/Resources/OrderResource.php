<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Management';
    protected static ?int $navigationSort = 3;

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([

            // ── Order Info ────────────────────────────────────────────────
            Infolists\Components\Section::make('Informasi Order')
                ->icon('heroicon-o-shopping-bag')
                ->columns(3)
                ->schema([
                    Infolists\Components\TextEntry::make('id')
                        ->label('Order ID')
                        ->copyable()
                        ->fontFamily('mono')
                        ->color('gray'),
                    Infolists\Components\TextEntry::make('status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'pending'     => 'warning',
                            'accepted'    => 'info',
                            'on_progress' => 'primary',
                            'completed'   => 'success',
                            'cancelled'   => 'danger',
                        }),
                    Infolists\Components\TextEntry::make('service.name')
                        ->label('Layanan')
                        ->badge()->color('primary'),
                    Infolists\Components\TextEntry::make('pickup_location')
                        ->label('Lokasi Jemput')
                        ->columnSpan(2),
                    Infolists\Components\TextEntry::make('destination_location')
                        ->label('Tujuan')
                        ->columnSpan(2),
                    Infolists\Components\TextEntry::make('price')
                        ->label('Total Harga')
                        ->money('IDR')
                        ->weight('bold')
                        ->color('success'),
                    Infolists\Components\TextEntry::make('notes')
                        ->label('Catatan')
                        ->default('-')
                        ->columnSpanFull(),
                    Infolists\Components\TextEntry::make('created_at')
                        ->label('Waktu Order')
                        ->dateTime('d M Y, H:i'),
                ]),

            // ── People ────────────────────────────────────────────────────
            Infolists\Components\Section::make('Customer & Driver')
                ->icon('heroicon-o-users')
                ->columns(2)
                ->schema([
                    Infolists\Components\Group::make([
                        Infolists\Components\TextEntry::make('user.name')
                            ->label('Customer')
                            ->weight('semibold'),
                        Infolists\Components\TextEntry::make('user.phone')
                            ->label('No. HP Customer')
                            ->default('-'),
                        Infolists\Components\TextEntry::make('user.address')
                            ->label('Alamat Customer')
                            ->default('-'),
                    ]),
                    Infolists\Components\Group::make([
                        Infolists\Components\TextEntry::make('driver.name')
                            ->label('Driver')
                            ->weight('semibold')
                            ->default('Belum ada driver'),
                        Infolists\Components\TextEntry::make('driver.phone')
                            ->label('No. HP Driver')
                            ->default('-'),
                        Infolists\Components\TextEntry::make('assignedDriver.name')
                            ->label('Driver Kandidat')
                            ->default('-')
                            ->helperText('Driver yang sudah dipilih sistem, menunggu konfirmasi user'),
                    ]),
                ]),

            // ── Food Items ────────────────────────────────────────────────
            Infolists\Components\Section::make('Item yang Dipesan')
                ->icon('heroicon-o-cake')
                ->schema([
                    Infolists\Components\RepeatableEntry::make('foodItems')
                        ->label('')
                        ->schema([
                            Infolists\Components\TextEntry::make('foodItem.name')
                                ->label('Menu'),
                            Infolists\Components\TextEntry::make('foodItem.store.name')
                                ->label('Dari Toko'),
                            Infolists\Components\TextEntry::make('qty')
                                ->label('Qty')
                                ->badge()->color('gray'),
                            Infolists\Components\TextEntry::make('price')
                                ->label('Harga Satuan')
                                ->money('IDR'),
                            Infolists\Components\TextEntry::make('subtotal')
                                ->label('Subtotal')
                                ->money('IDR')
                                ->weight('semibold')
                                ->color('success')
                                ->state(fn ($record) => $record->price * $record->qty),
                        ])
                        ->columns(5)
                        ->contained(false),
                ])
                ->visible(fn (Order $record): bool => $record->foodItems->isNotEmpty()),

        ]);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')->searchable()->required(),
                Forms\Components\Select::make('driver_id')
                    ->relationship('driver', 'name')->searchable()->nullable(),
                Forms\Components\Select::make('service_id')
                    ->relationship('service', 'name')->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending'     => 'Pending',
                        'accepted'    => 'Accepted',
                        'on_progress' => 'On Progress',
                        'completed'   => 'Completed',
                        'cancelled'   => 'Cancelled',
                    ])->required(),
                Forms\Components\TextInput::make('pickup_location')->required()->columnSpanFull(),
                Forms\Components\TextInput::make('destination_location')->required()->columnSpanFull(),
                Forms\Components\TextInput::make('price')->numeric()->required()->prefix('Rp'),
                Forms\Components\Textarea::make('notes')->rows(2)->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->limit(8)->tooltip(fn ($record) => $record->id),
                Tables\Columns\TextColumn::make('user.name')->label('Customer')->searchable(),
                Tables\Columns\TextColumn::make('driver.name')->label('Driver')->default('-'),
                Tables\Columns\TextColumn::make('service.name')->label('Service')->badge()->color('primary'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'     => 'warning',
                        'accepted'    => 'info',
                        'on_progress' => 'primary',
                        'completed'   => 'success',
                        'cancelled'   => 'danger',
                    }),
                Tables\Columns\TextColumn::make('price')->money('IDR')->sortable(),
                Tables\Columns\TextColumn::make('food_items_count')
                    ->counts('foodItems')
                    ->label('Items')
                    ->badge()->color('gray'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'     => 'Pending',
                        'accepted'    => 'Accepted',
                        'on_progress' => 'On Progress',
                        'completed'   => 'Completed',
                        'cancelled'   => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('service')->relationship('service', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view'   => Pages\ViewOrder::route('/{record}'),
            'edit'   => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
