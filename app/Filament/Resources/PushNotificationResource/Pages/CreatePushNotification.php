<?php

namespace App\Filament\Resources\PushNotificationResource\Pages;

use App\Filament\Resources\PushNotificationResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePushNotification extends CreateRecord
{
    protected static string $resource = PushNotificationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['sent_by'] = auth()->id();
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('create_and_send')
                ->label('Buat & Kirim Sekarang')
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->action(function () {
                    $data = $this->form->getState();
                    $data['sent_by'] = auth()->id();
                    $record = $this->getModel()::create($data);
                    PushNotificationResource::broadcast($record);
                    Notification::make()
                        ->title("Notifikasi dikirim ke {$record->recipient_count} user")
                        ->success()->send();
                    $this->redirect(PushNotificationResource::getUrl('index'));
                }),
        ];
    }
}
