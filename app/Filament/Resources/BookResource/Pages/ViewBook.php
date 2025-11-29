<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewBook extends ViewRecord
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('download')
                ->label('Download PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function ($record) {
                    $record->increment('counter');

                    return response()->download(
                        storage_path('app/public/'.$record->pdf_file)
                    );
                })
                ->visible(fn ($record) => $record->pdf_file !== null),
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Book Cover')
                ->schema([
                    Infolists\Components\ImageEntry::make('cover')
                            ->height(200)
                            ->defaultImageUrl(url('/images/default-book-cover.png')),
                ]),


            Infolists\Components\Section::make('Book Details')
                ->schema([
                    Infolists\Components\TextEntry::make('isbn')
                        ->label('ISBN')
                        ->copyable(),

                    Infolists\Components\TextEntry::make('title')
                        ->extraAttributes(['class' => 'text-lg tracking-wide'])
                            ->weight('semibold')
                            ->color('primary'),

                    Infolists\Components\TextEntry::make('category.name_category')
                        ->label('Categories')
                        ->badge()
                        ->separator(),

                    Infolists\Components\TextEntry::make('author.name')
                        ->label('Author'),

                    Infolists\Components\TextEntry::make('publisher'),

                    Infolists\Components\TextEntry::make('year'),

                    Infolists\Components\TextEntry::make('pdf_file')
                        ->label('PDF File')
                        ->formatStateUsing(fn ($state) => $state ? '✓ Available' : '✗ Not Uploaded')
                        ->badge()
                        ->color(fn ($state) => $state ? 'success' : 'gray')
                        ->url(fn ($record) =>
                            $record->pdf_file
                                ? asset('storage/' . $record->pdf_file)
                                : null
                        )
                        ->openUrlInNewTab(),

                    Infolists\Components\TextEntry::make('counter')
                            ->label('Jumlah PDF Terdownload')
                            ->icon('heroicon-o-arrow-down-tray')
                            ->badge()
                            ->color('info'),

                    Infolists\Components\TextEntry::make('status')
                        ->badge()
                        ->color(fn ($state) => match ($state) {
                            'available' => 'success',
                            'borrowed'  => 'warning',
                            default     => 'gray',
                        })
                        ->formatStateUsing(fn ($state) => ucfirst($state)),

                ])
                ->columns(2),
                Infolists\Components\Section::make('Book Gallery')
                    ->schema([
                        Infolists\Components\ImageEntry::make('gallery')
                            ->disk('public')
                            ->height(150)
                            ->stacked(false)
                            ->columnSpanFull()
                            ->limit(5),
                    ])
        ]);
    }
}
