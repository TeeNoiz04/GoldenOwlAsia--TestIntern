<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Domain\Statistics\ScienceGroupStatisticsCalculator;
use App\Domain\Statistics\SocialGroupStatisticsCalculator;

class TotalStudents extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 12;
    
    protected function getStats(): array
    {
        $scienceCalculator = new ScienceGroupStatisticsCalculator();
        $socialCalculator = new SocialGroupStatisticsCalculator();

        $percentScience = $scienceCalculator->calculatePercent();
        $percentSocial = $socialCalculator->calculatePercent();
        return [
            Stat::make('Total Students', $scienceCalculator->getTotalStudent())
                ->description('Number of all registered students')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success')
                ->extraAttributes([

                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ]),
            Stat::make('Science Group Percentage', $percentScience . '%')
                ->description('Percentage of students not in the poor category')
                ->descriptionIcon('heroicon-o-chart-bar-square')
                ->color('success')
                ->extraAttributes([

                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ]),
            Stat::make('Social Group Percentage', $percentSocial . '%')
                ->description('Percentage of students not in the poor category')
                ->descriptionIcon('heroicon-o-chart-bar-square')->color('success')
                ->extraAttributes([

                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ]),
        ];
    }
}
