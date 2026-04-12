<?php

namespace App\Filament\Resources\PushNotificationResource\Pages;

use App\Filament\Resources\PushNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPushNotification extends ViewRecord
{
    protected static string $resource = PushNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn () => is_null($this->record->sent_at)),
            Actions\Action::make('broadcast')
                ->label('Kirim Sekarang')
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->visible(fn () => is_null($this->record->sent_at))
                ->requiresConfirmation()
                ->action(function () {
                    PushNotificationResource::broadcast($this->record);
                    \Filament\Notifications\Notification::make()
                        ->title("Terkirim ke {$this->record->recipient_count} user")
                        ->success()->send();
                    $this->refreshFormData([]);
                }),
        ];
    }
}
