<?php

namespace App\Domain\Group;

use App\Models\Student;

final class GroupD01
{
    public static function total(Student $student): float
    {
        return (float) (
            $student->toan
            + $student->ngu_van
            + $student->ngoai_ngu
        );
    }
}
