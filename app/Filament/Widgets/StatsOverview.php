<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Revenue', 'Rp ' . number_format(Order::where('status', '!=', 'cancelled')->sum('total_price'), 0, ',', '.'))
                ->description('Revenue (excluding cancelled)')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Orders', Order::count())
                ->description(
                    (function () {
                        $counts = Order::selectRaw('status, count(*) as count')
                            ->groupBy('status')
                            ->pluck('count', 'status')
                            ->toArray();

                        $parts = [];
                        if (isset($counts['completed'])) $parts[] = 'Completed ' . $counts['completed'];
                        if (isset($counts['cancelled'])) $parts[] = 'Cancelled ' . $counts['cancelled'];
                        if (isset($counts['processing'])) $parts[] = 'Processing ' . $counts['processing'];
                        if (isset($counts['pending'])) $parts[] = 'Pending ' . $counts['pending'];

                        return implode(', ', $parts);
                    })()
                )
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),
            Stat::make('Average Order Value', 'Rp ' . number_format(Order::where('status', '!=', 'cancelled')->avg('total_price'), 0, ',', '.'))
                ->description('Average per (valid) order')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),
        ];
    }
}
