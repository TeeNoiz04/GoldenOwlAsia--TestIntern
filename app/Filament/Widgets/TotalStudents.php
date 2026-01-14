<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Domain\Statistics\ScienceGroupCalculator;

class TotalStudents extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 12;
    
    protected function getStats(): array
    {
        $calculator = new ScienceGroupCalculator();
        $percent = $calculator->calculatePercent();
        return [
            Stat::make('Total Students', $calculator->getTotalStudent())
                ->description('Number of all registered students')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success')
                ->extraAttributes([

                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ]),
            Stat::make('Science Group Percentage', $percent . '%')
                ->description('Percentage of students not in the poor category')
                ->descriptionIcon('heroicon-o-chart-bar-square')
                ->color('success')
                ->extraAttributes([

                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ]),
            Stat::make('Social Group Percentage', (new \App\Domain\Statistics\SocialGroupCalculator())->calculatePercent() . '%')
                ->description('Percentage of students not in the poor category')
                ->descriptionIcon('heroicon-o-chart-bar-square')->color('success')
                ->extraAttributes([

                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ]),
        ];
    }
}
