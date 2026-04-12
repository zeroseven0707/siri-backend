<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Management';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')->searchable()->required(),
                Forms\Components\Select::make('order_id')
                    ->relationship('order', 'id')->searchable()->nullable(),
                Forms\Components\TextInput::make('amount')->numeric()->required()->prefix('Rp'),
                Forms\Components\Select::make('type')
                    ->options(['topup' => 'Top Up', 'payment' => 'Payment', 'refund' => 'Refund'])->required(),
                Forms\Components\Select::make('status')
                    ->options(['pending' => 'Pending', 'success' => 'Success', 'failed' => 'Failed'])->required(),
                Forms\Components\TextInput::make('reference')->maxLength(255),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')->searchable()->default('-'),
                Tables\Columns\TextColumn::make('user.name')->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'topup'   => 'success',
                        'payment' => 'primary',
                        'refund'  => 'warning',
                    }),
                Tables\Columns\TextColumn::make('amount')->money('IDR')->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success' => 'success',
                        'pending' => 'warning',
                        'failed'  => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options(['topup' => 'Top Up', 'payment' => 'Payment', 'refund' => 'Refund']),
                Tables\Filters\SelectFilter::make('status')
                    ->options(['pending' => 'Pending', 'success' => 'Success', 'failed' => 'Failed']),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
        ];
    }
}
