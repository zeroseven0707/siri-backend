<?php

namespace App\Filament\Resources\HomeSectionResource\Pages;

use App\Filament\Resources\HomeSectionResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditHomeSection extends EditRecord
{
    protected static string $resource = HomeSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('sync')
                ->label('Sync Items')
                ->icon('heroicon-o-arrow-path')
                ->color('info')
                ->visible(fn (): bool =>
                    in_array($this->record->type, ['store_list', 'food_list', 'service_list']))
                ->requiresConfirmation()
                ->modalHeading('Sync Section Items')
                ->modalDescription('Update semua item dari data terbaru di source table-nya (nama, deskripsi, harga).')
                ->action(function () {
                    $this->record->load('items');
                    $synced = HomeSectionResource::syncSection($this->record);
                    $this->refreshFormData(['items']);
                    Notification::make()
                        ->title("Sync selesai — {$synced} item diperbarui")
                        ->success()
                        ->send();
                }),
            Actions\DeleteAction::make(),
        ];
    }
}
