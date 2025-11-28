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
                ->color('success'),
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Book Cover')
                ->schema([
                    Infolists\Components\ImageEntry::make('thumbnail')
                    ->label('Cover')
                    ->height(240)
                    ->defaultImageUrl(url('https://placehold.co/200x300?text=Book+ID+' . 'id' . '&font=roboto'))
                    ->getStateUsing(function ($record) {
                        if ($record->thumbnail) {
                            return asset('storage/' . $record->thumbnail);
                        }
                        if ($record->cover) {
                            return asset('storage/' . $record->cover);
                        }
                        return null;
                    }),
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
                            ->stacked()
                            ->columnSpanFull(),
                    ])
        ]);
    }
}
