<?php

namespace App\Domain\Statistics;

use App\Models\SubjectStatistic;
use App\Models\Student;

class SocialGroupCalculator
{

    private const SOCIAL_SUBJECTS = [
        'lich_su',
        'dia_ly',
        'gdcd',
    ];
    public function getTotalStudent(): int
    {
        return Student::count();
    }
    public function calculatePercent(): float
    {
        $totalStudents = Student::count();

        if ($totalStudents === 0) {
            return 0;
        }

        $arrayTotalSubject = SubjectStatistic::whereIn('subject', self::SOCIAL_SUBJECTS)
            ->selectRaw('subject, SUM(excellent + good + average) as total')
            ->groupBy('subject')
            ->get();


        if ($arrayTotalSubject->isEmpty()) {
            return 0;
        }

        $maxTotal = $arrayTotalSubject->max('total');
    
        return round(
            ($maxTotal / $totalStudents) * 100,2
        );
    }
}
