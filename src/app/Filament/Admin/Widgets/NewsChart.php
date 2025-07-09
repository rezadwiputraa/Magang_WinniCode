<?php

namespace App\Filament\Widgets;

use App\Models\News;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class NewsChart extends ChartWidget
{
    protected static ?string $heading = 'News Chart';

    protected static ?int $sort = 3;

    protected static ?string $maxHeight = '300px';


    protected function getData(): array
    {
        $data = $this->getNewsPerMonth();

        return [
            'datasets' => [
                [
                    'label' => 'News posts created',
                    'data' => $data['newsPerMonth'],
                ],
            ],
            'labels' => $data['months'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }


    private function getNewsPerMonth(): array
    {
        $now = Carbon::now();

        $newsPerMonth = [];

        $months = collect(range(1, 12))->map(function ($month) use ($now, &$newsPerMonth) {
            $count = News::whereYear('created_at', $now->year)
                         ->whereMonth('created_at', $month)
                         ->count();

            $newsPerMonth[] = $count;

            return Carbon::create()->month($month)->format('M');
        })->toArray();

        return [

            'newsPerMonth' => $newsPerMonth,
            'months' => $months

        ];
    }
}
