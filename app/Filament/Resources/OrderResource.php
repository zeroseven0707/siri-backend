<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Management';
    protected static ?int $navigationSort = 3;

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
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit'   => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
