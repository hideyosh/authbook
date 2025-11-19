<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\Author;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Books', Book::count()),
            Stat::make('Total Authors', Author::count())
        ];
    }
}
