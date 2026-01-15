<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\SubjectStatistic;
use App\Domain\Statistics\SubjectConfig;

class ScoreStatisticsLineChart extends ChartWidget
{
    protected static ?string $heading = 'Score Statistics - Line Chart';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 12;
    protected static ?string $minHeight = '520px';
    protected static ?string $maxHeight = '520px';

    protected function getData(): array
    {
        $subjects = SubjectConfig::getAllKeys();

        $stats = SubjectStatistic::whereIn('subject', $subjects)
            ->orderByRaw("FIELD(subject, '" . implode("','", $subjects) . "')")
            ->get();

        return [
            // X-axis: subjects
            'labels' => $stats->pluck('subject')
                ->map(fn($s) => SubjectConfig::getDisplayName($s)),

            // 4 lines = 4 levels
            'datasets' => [
                [
                    'label' => 'Excellent',
                    'data' => $stats->pluck('excellent'),
                    'borderColor' => '#22c55e',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Good',
                    'data' => $stats->pluck('good'),
                    'borderColor' => '#3b82f6',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Average',
                    'data' => $stats->pluck('average'),
                    'borderColor' => '#facc15',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Poor',
                    'data' => $stats->pluck('poor'),
                    'borderColor' => '#ef4444',
                    'tension' => 0.4,
                ],
            ],
        ];
    }
   
    protected function getType(): string
    {
        return 'line';
    }
}
