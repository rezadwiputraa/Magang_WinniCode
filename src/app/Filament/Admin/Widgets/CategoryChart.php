<?php

namespace App\Filament\Widgets;

use App\Models\News;
use App\Models\NewsCategory;
use Filament\Widgets\ChartWidget;

class CategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Berita per Kategori';

    protected static ?int $sort = 3;

    protected static ?string $maxHeight = '300px';


    protected function getData(): array
{
    $categories = \App\Models\NewsCategory::withCount('news')->get();

    // Mapping nama kategori ke warna tetap
    $colorMap = [
        'Sport' => '#FF6384',
        'Entertainment' => '#36A2EB',
        'Health' => '#FFCE56',
        'Foods' => '#4BC0C0',
        'Politics' => '#6200ff',
    ];

    // Ambil warna berdasarkan nama kategori
    $colors = $categories->map(function ($category) use ($colorMap) {
        return $colorMap[$category->title] ?? '#CCCCCC'; // fallback warna abu-abu
    });

    return [
        'datasets' => [
            [
                'label' => 'Jumlah Berita',
                'data' => $categories->pluck('news_count'),
                'backgroundColor' => $colors,
            ],
        ],
        'labels' => $categories->pluck('title'),
    ];
}

    protected function getType(): string
    {
        return 'doughnut';
    }
}
