<?php

namespace App\Filament\Widgets;

use App\Models\Author;
use App\Models\BannerAdvertisement;
use App\Models\News;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = '15s';

    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        return [
            stat::make('Total News', News::count())

                ->description('Increase in News')

                ->descriptionIcon('heroicon-m-arrow-trending-up')

                ->color('success')

                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

             stat::make('Total Authors', Author::count())

                ->description('Increase in Authors')

                ->descriptionIcon('heroicon-m-arrow-trending-up')

                ->color('success')

                ->chart([7, 3, 4, 5, 6, 9, 3, 5]),

            stat::make('Total Advertisements', BannerAdvertisement::count())

                ->description('Increase in Advertisements')

                ->descriptionIcon('heroicon-m-arrow-trending-down')

                ->color('danger')

                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
        ];
    }
}
