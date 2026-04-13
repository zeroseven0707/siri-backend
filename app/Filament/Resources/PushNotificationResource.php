<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PushNotificationResource\Pages;
use App\Models\PushNotification;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PushNotificationResource extends Resource
{
    protected static ?string $model = PushNotification::class;
    protected static ?string $navigationIcon = 'heroicon-o-bell';
    protected static ?string $navigationLabel = 'Push Notifications';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 2;

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Detail Notifikasi')
                ->icon('heroicon-o-bell')
                ->columns(3)
                ->schema([
                    Infolists\Components\TextEntry::make('title')
                        ->label('Judul')->columnSpan(2)->weight('bold'),
                    Infolists\Components\TextEntry::make('type')
                        ->label('Tipe')->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'promo'        => 'success',
                            'order_status' => 'warning',
                            'system'       => 'gray',
                        })
                        ->formatStateUsing(fn (string $state): string => match ($state) {
                            'promo'        => '🎁 Promo',
                            'order_status' => '📦 Status Pesanan',
                            'system'       => '⚙️ System',
                        }),
                    Infolists\Components\TextEntry::make('body')
                        ->label('Isi Pesan')->columnSpanFull(),
                    Infolists\Components\ImageEntry::make('image')
                        ->label('Gambar')->columnSpanFull()
                        ->visible(fn ($record) => !is_null($record->image)),
                    Infolists\Components\TextEntry::make('target')
                        ->label('Target')->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'all'    => 'primary',
                            'user'   => 'success',
                            'driver' => 'warning',
                        }),
                    Infolists\Components\TextEntry::make('recipient_count')
                        ->label('Terkirim ke')->suffix(' user')->badge()->color('gray'),
                    Infolists\Components\TextEntry::make('sent_at')
                        ->label('Waktu Kirim')->dateTime('d M Y, H:i')
                        ->placeholder('Belum dikirim'),
                    Infolists\Components\TextEntry::make('sender.name')
                        ->label('Dibuat oleh'),
                ]),

            Infolists\Components\Section::make('Pembaca')
                ->icon('heroicon-o-eye')
                ->description(fn ($record) => "Dari {$record->recipient_count} penerima, " . $record->readers->count() . " sudah membaca")
                ->schema([
                    Infolists\Components\RepeatableEntry::make('readers')
                        ->label('')
                        ->schema([
                            Infolists\Components\TextEntry::make('name')->label('Nama'),
                            Infolists\Components\TextEntry::make('email')->label('Email'),
                            Infolists\Components\TextEntry::make('role')->label('Role')->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'user'   => 'success',
                                    'driver' => 'warning',
                                    'admin'  => 'danger',
                                    default  => 'gray',
                                }),
                            Infolists\Components\TextEntry::make('pivot.read_at')
                                ->label('Dibaca pada')
                                ->dateTime('d M Y, H:i'),
                        ])
                        ->columns(4)
                        ->contained(false),
                ])
                ->visible(fn ($record) => !is_null($record->sent_at)),
        ]);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('title')
                    ->required()->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('body')
                    ->required()->rows(4)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->image()->directory('notifications')->visibility('public')->nullable()->columnSpanFull(),
                Forms\Components\Select::make('target')
                    ->options([
                        'all'    => 'Semua User',
                        'user'   => 'User (Customer)',
                        'driver' => 'Driver',
                    ])
                    ->default('all')
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'promo'        => '🎁 Promo',
                        'order_status' => '📦 Status Pesanan',
                        'system'       => '⚙️ System',
                    ])
                    ->default('system')
                    ->required(),
                Forms\Components\KeyValue::make('data')
                    ->label('Extra Data (opsional)')
                    ->nullable()
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()->sortable()->limit(40),
                Tables\Columns\TextColumn::make('body')
                    ->limit(60)->color('gray'),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'promo'        => 'success',
                        'order_status' => 'warning',
                        'system'       => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'promo'        => '🎁 Promo',
                        'order_status' => '📦 Status Pesanan',
                        'system'       => '⚙️ System',
                    }),
                Tables\Columns\TextColumn::make('target')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'all'    => 'primary',
                        'user'   => 'success',
                        'driver' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('recipient_count')
                    ->label('Terkirim ke')
                    ->suffix(' user')
                    ->badge()->color('gray'),
                Tables\Columns\IconColumn::make('sent_at')
                    ->label('Terkirim')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->state(fn ($record) => !is_null($record->sent_at)),
                Tables\Columns\TextColumn::make('sender.name')
                    ->label('Dikirim oleh'),
                Tables\Columns\TextColumn::make('sent_at')
                    ->label('Waktu Kirim')
                    ->formatStateUsing(fn ($state) => $state ? \Carbon\Carbon::parse($state)->format('d M Y H:i') : '-')
                    ->placeholder('-')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                // Tombol broadcast — kirim notif ke semua target
                Tables\Actions\Action::make('broadcast')
                    ->label('Kirim Sekarang')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->visible(fn (PushNotification $record): bool => is_null($record->sent_at))
                    ->requiresConfirmation()
                    ->modalHeading('Kirim Push Notification')
                    ->modalDescription(fn (PushNotification $record) =>
                        "Notifikasi \"{$record->title}\" akan dikirim ke semua {$record->target}.")
                    ->action(function (PushNotification $record) {
                        static::broadcast($record);
                        Notification::make()
                            ->title("Notifikasi berhasil dikirim ke {$record->recipient_count} user")
                            ->success()->send();
                    }),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn (PushNotification $record): bool => is_null($record->sent_at)),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('broadcast_selected')
                        ->label('Kirim yang Dipilih')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (\Illuminate\Support\Collection $records) {
                            $total = 0;
                            foreach ($records->filter(fn ($r) => is_null($r->sent_at)) as $record) {
                                static::broadcast($record);
                                $total += $record->recipient_count;
                            }
                            Notification::make()
                                ->title("Berhasil dikirim ke {$total} user")
                                ->success()->send();
                        }),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // ── Broadcast logic ───────────────────────────────────────────────────
    public static function broadcast(PushNotification $notification): void
    {
        $fcm = app(\App\Services\FcmService::class);
        $sent = $fcm->broadcast($notification);

        // Fallback count kalau FCM tidak dikonfigurasi
        if ($sent === 0) {
            $query = \App\Models\User::query();
            if ($notification->target !== 'all') {
                $query->where('role', $notification->target);
            } else {
                $query->whereIn('role', ['user', 'driver']);
            }
            $sent = $query->count();
        }

        $notification->update([
            'sent_at'         => now(),
            'recipient_count' => $sent,
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPushNotifications::route('/'),
            'create' => Pages\CreatePushNotification::route('/create'),
            'view'   => Pages\ViewPushNotification::route('/{record}'),
            'edit'   => Pages\EditPushNotification::route('/{record}/edit'),
        ];
    }
}
