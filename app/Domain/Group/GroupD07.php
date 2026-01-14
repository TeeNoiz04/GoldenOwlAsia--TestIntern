<?php

namespace App\Domain\Group;

use App\Models\Student;

final class GroupD07
{
    public static function total(Student $student): float
    {
        return (float) (
            $student->toan
            + $student->ngoai_ngu
            + $student->hoa_hoc
        );
    }
}
