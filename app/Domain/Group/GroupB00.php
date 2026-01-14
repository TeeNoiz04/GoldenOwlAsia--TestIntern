<?php

namespace App\Domain\Group;

use App\Models\Student;

final class GroupB00
{
    public static function total(Student $student): float
    {
        return (float) (
            $student->toan
            + $student->sinh_hoc
            + $student->hoa_hoc
        );
    }
}
