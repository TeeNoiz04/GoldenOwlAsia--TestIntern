<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
class Top10GroupB00Students extends BaseWidget
{
    protected static ?string $heading = 'Top 10 Students - Group B00';
    protected static ?int $sort = 6;
    protected int | string | array $columnSpan = 12;
    protected static bool $isLazy = false;

    protected function getTableQuery(): Builder
    {
        return Student::query()
            ->select('*')
            ->selectRaw('(toan + hoa_hoc + sinh_hoc) as total_group_b00')
            ->orderByDesc('total_group_b00')
            ->limit(10);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('sbd')
                ->label('SBD'),

            Tables\Columns\TextColumn::make('total_group_b00')
                ->label('Total Group B00'),

        ];
    }
    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

}
