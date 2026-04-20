<?php

namespace App\Livewire;

use App\Models\Expenses;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $ownContribution = Expenses::where('done_by', auth()->id())->sum('amount');
        $partnerContribution = Expenses::where('done_by', '!=', auth()->id())->sum('amount');
        $mostExpenseSourceName = Expenses::with('expense_source')
            ->selectRaw('expense_source_id, SUM(amount) as total_amount')
            ->groupBy('expense_source_id')
            ->orderByDesc('total_amount')
            ->first()
            ?->expense_source
            ?->name;
        return [
            Stat::make('Own Contribution', 'Own Contribution')
                ->formatStateUsing(fn($state) => '₹ ' . number_format($state, 2))
                ->description('Your total contributions')
                ->icon('heroicon-o-credit-card')
                ->color('primary')
                ->value($ownContribution),
            Stat::make('Partner Contribution', 'Partner Contribution')
                ->formatStateUsing(fn($state) => '₹ ' . number_format($state, 2))
                ->description('Your partner\'s total contributions')
                ->icon('heroicon-o-users')
                ->color('success')
                ->value($partnerContribution),
            Stat::make('Total Contribution', 'Total Contribution')
                ->formatStateUsing(fn($state) => '₹ ' . number_format($state, 2))
                ->description('Total contributions')
                ->icon('heroicon-o-chart-bar')
                ->color('warning')
                ->value($ownContribution + $partnerContribution),
            Stat::make('Most money spent on', 'Most Expensive Category')
                ->description('Item with the highest expenses')
                ->icon('heroicon-o-chart-pie')
                ->color('danger')
                ->value($mostExpenseSourceName ?? 'N/A'),
        ];
    }
}
