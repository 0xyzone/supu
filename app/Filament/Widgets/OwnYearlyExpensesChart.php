<?php

namespace App\Filament\Widgets;

use App\Models\Expenses;
use Filament\Widgets\ChartWidget;

class OwnYearlyExpensesChart extends ChartWidget
{
    protected ?string $heading = 'Yearly Expenses Chart Segregated';
    protected static ?int $sort = 3;
    protected function getData(): array
    {
        $ownExpenses = Expenses::where('done_by', auth()->id())
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();
        $partnerExpenses = Expenses::where('done_by', "!=", auth()->id() ?? null)
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $owndata = array_map(fn($month) => $ownExpenses[$month]['total'] ?? 0, range(1, 12));
        $partnerdata = array_map(fn($month) => $partnerExpenses[$month]['total'] ?? 0, range(1, 12));
        return [
            'datasets' => [
                [
                    'label' => 'Own Expenses',
                    'data' => array_values($owndata),
                    'backgroundColor' => 'rgba(54, 162, 235, 1)',
                ],
                [
                    'label' => 'Partner Expenses',
                    'data' => array_values($partnerdata),
                    'backgroundColor' => 'rgba(255, 99, 132, 1)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
