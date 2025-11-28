<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class EditBook extends EditRecord
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['cover'])) {

            $thumbnailPath = 'book-covers/thumbnails/' . basename($data['cover']);

            $fullCoverPath = storage_path('app/public/' . $data['cover']);
            $fullThumbPath = storage_path('app/public/' . $thumbnailPath);

            if (!is_dir(dirname($fullThumbPath))) {
                mkdir(dirname($fullThumbPath), 0755, true);
            }

            $manager = new ImageManager(new Driver());
            $manager->read($fullCoverPath)
                ->resize(200, 300)
                ->save($fullThumbPath);

            $data['thumbnail'] = $thumbnailPath;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Informasi buku diubah')
            ->body('Berhasil mengubah informasi buku.');
    }
}
