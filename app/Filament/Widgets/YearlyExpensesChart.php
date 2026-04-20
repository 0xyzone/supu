<?php

namespace App\Filament\Widgets;

use App\Models\Expenses;
use Filament\Widgets\ChartWidget;

class YearlyExpensesChart extends ChartWidget
{
    protected ?string $heading = 'Yearly Expenses Chart';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = "1/4";

    protected function getData(): array
    {
        $data = Expenses::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data = array_map(fn($month) => $data[$month]['total'] ?? 0, range(1, 12));
        return [
            'datasets' => [
                [
                    'label' => 'Expenses',
                    'data' => array_values($data),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
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
