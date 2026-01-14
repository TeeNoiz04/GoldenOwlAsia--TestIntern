<?php

namespace App\Domain\Group;

use App\Models\Student;

final class GroupA00
{
    public static function total(Student $student): float
    {
        return (float) (
            $student->toan
            + $student->vat_ly
            + $student->hoa_hoc
        );
    }
}
