<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRevenue = Transaction::where('type', 'payment')
            ->where('status', 'success')->sum('amount');

        $todayOrders = Order::whereDate('created_at', today())->count();

        return [
            Stat::make('Total Users', User::where('role', 'user')->count())
                ->description('Registered customers')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Total Drivers', User::where('role', 'driver')->count())
                ->description('Active drivers')
                ->descriptionIcon('heroicon-m-truck')
                ->color('success'),

            Stat::make('Total Stores', Store::where('is_active', true)->count())
                ->description('Active stores')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('warning'),

            Stat::make('Orders Today', $todayOrders)
                ->description('Orders placed today')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('info'),

            Stat::make('Pending Orders', Order::where('status', 'pending')->count())
                ->description('Waiting for driver')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('From completed payments')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
