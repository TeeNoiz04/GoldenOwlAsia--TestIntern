<?php

namespace App\Filament\Widgets;

use App\Domain\Statistics\Subjects;
use App\Models\SubjectStatistic;
use Filament\Widgets\ChartWidget;

class ScoreStatisticsBarChart extends ChartWidget
{
    protected static ?string $heading = 'Score Statistics by Subject - Bar Chart';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 12;
    protected static ?string $minHeight = '520px';
    protected static ?string $maxHeight = '520px';
    
    protected function getFilters(): ?array
    {
        return [
            'toan' => 'Math',
            'vat_li' => 'Physics',
            'hoa_hoc' => 'Chemistry',
            'sinh_hoc' => 'Biology',
            'lich_su' => 'History',
            'dia_li' => 'Geography',
            'gdcd' => 'Civic Education',
            'ngu_van' => 'Literature',
            'ngoai_ngu' => 'Foreign Language',
        ];
    }


    protected function getData(): array
    {
        $subject = $this->filter ?? 'toan';
        $stat = SubjectStatistic::where('subject', $subject)->first();

        if (! $stat) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => Subjects::ALL[$subject],
                    'data' => [
                        $stat->excellent ?? 0,
                        $stat->good ?? 0,
                        $stat->average ?? 0,
                        $stat->poor ?? 0,
                    ],
                    'backgroundColor' => [
                        '#c05621', // Excellent 
                        '#dd6b20', // Good
                        '#f6ad55', // Average
                        '#fbd38d', // Poor 
                    ],
                ],
            ],
            'labels' => [
                'Excellent (>= 8)',
                'Good (6–7.9)',
                'Average (4–5.9)',
                'Poor (< 4)',
            ],
        ];
    }


    protected function getType(): string
    {
        return 'bar';
    }
}
