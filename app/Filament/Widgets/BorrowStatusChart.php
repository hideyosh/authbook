<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use Filament\Widgets\ChartWidget;

class BorrowStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Borrowed vs Available';

    protected function getData(): array
    {
        $borrowed = Book::where('status', 'borrowed')->count();
        $available = Book::where('status', 'available')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Borrowed',
                    'data' => [$borrowed],
                    'backgroundColor' => 'rgba(255, 99, 132, 0.8)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Available',
                    'data' => [$available],
                    'backgroundColor' => 'rgba(75, 192, 75, 0.8)',
                    'borderColor' => 'rgba(75, 192, 75, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Books'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
