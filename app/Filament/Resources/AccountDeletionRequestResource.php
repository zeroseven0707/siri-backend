<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountDeletionRequestResource\Pages;
use App\Models\AccountDeletionRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AccountDeletionRequestResource extends Resource
{
    protected static ?string $model = AccountDeletionRequest::class;
    protected static ?string $navigationIcon = 'heroicon-o-trash';
    protected static ?string $navigationLabel = 'Hapus Akun';
    protected static ?string $navigationGroup = 'Management';
    protected static ?int $navigationSort = 6;

    public static function getNavigationBadge(): ?string
    {
        $count = AccountDeletionRequest::where('status', 'pending')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Detail Permintaan')->columns(2)->schema([
                Infolists\Components\TextEntry::make('user.name')->label('Nama User'),
                Infolists\Components\TextEntry::make('user.email')->label('Email'),
                Infolists\Components\TextEntry::make('user.phone')->label('No. HP'),
                Infolists\Components\TextEntry::make('status')->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'  => 'warning',
                        'approved' => 'danger',
                        'rejected' => 'success',
                    }),
                Infolists\Components\TextEntry::make('reason')->label('Alasan')->default('-')->columnSpanFull(),
                Infolists\Components\TextEntry::make('rejection_note')->label('Catatan Penolakan')->default('-')->columnSpanFull(),
                Infolists\Components\TextEntry::make('reviewer.name')->label('Direview oleh')->default('-'),
                Infolists\Components\TextEntry::make('reviewed_at')->label('Waktu Review')->dateTime('d M Y, H:i')->placeholder('-'),
                Infolists\Components\TextEntry::make('created_at')->label('Diajukan pada')->dateTime('d M Y, H:i'),
            ]),
        ]);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Select::make('status')
                    ->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'])
                    ->required(),
                Forms\Components\Textarea::make('rejection_note')
                    ->label('Catatan Penolakan')
                    ->rows(3)
                    ->visible(fn (Forms\Get $get) => $get('status') === 'rejected')
                    ->live(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User')->searchable(),
                Tables\Columns\TextColumn::make('user.email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('reason')->label('Alasan')->limit(50)->default('-'),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'  => 'warning',
                        'approved' => 'danger',
                        'rejected' => 'success',
                    }),
                Tables\Columns\TextColumn::make('created_at')->label('Diajukan')->dateTime('d M Y')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected']),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\Action::make('approve')
                    ->label('Setujui & Hapus Akun')
                    ->icon('heroicon-o-check-circle')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Penghapusan Akun')
                    ->modalDescription('Akun user akan dihapus permanen. Tindakan ini tidak bisa dibatalkan.')
                    ->action(function ($record) {
                        $record->update([
                            'status'      => 'approved',
                            'reviewed_by' => auth()->id(),
                            'reviewed_at' => now(),
                        ]);
                        // Hapus akun user
                        $record->user->delete();
                        Notification::make()->title('Akun berhasil dihapus')->success()->send();
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('rejection_note')
                            ->label('Alasan Penolakan')
                            ->required()->rows(3),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status'          => 'rejected',
                            'reviewed_by'     => auth()->id(),
                            'reviewed_at'     => now(),
                            'rejection_note'  => $data['rejection_note'],
                        ]);
                        Notification::make()->title('Permintaan berhasil ditolak')->success()->send();
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccountDeletionRequests::route('/'),
            'view'  => Pages\ViewAccountDeletionRequest::route('/{record}'),
        ];
    }
}
