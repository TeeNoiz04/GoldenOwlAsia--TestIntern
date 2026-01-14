<?php

namespace App\Domain\Group;

use App\Models\Student;

final class GroupC00
{
    public static function total(Student $student): float
    {
        return (float) (
            $student->ngu_van
            + $student->lich_su
            + $student->dia_li
        );
    }
}
