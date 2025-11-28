<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CreateBook extends CreateRecord
{
    protected static string $resource = BookResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['cover'])) {

            $thumbnailPath = 'book-covers/thumbnails/' . basename($data['cover']);

            $fullCoverPath = storage_path('app/public/' . $data['cover']);
            $fullThumbPath = storage_path('app/public/' . $thumbnailPath);

            // Pastikan folder ada
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

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Book ditambahkan')
            ->body('Buku berhasil ditambahkan dalam daftar.');
    }
}
