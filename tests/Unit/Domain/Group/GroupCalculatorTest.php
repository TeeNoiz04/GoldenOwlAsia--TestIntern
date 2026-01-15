<?php

namespace Tests\Unit\Domain\Group;

use Tests\TestCase;
use App\Models\Student;
use App\Domain\Group\Calculators\GroupA00Calculator;
use App\Domain\Group\Calculators\GroupA01Calculator;
use App\Domain\Group\Calculators\GroupB00Calculator;

class GroupCalculatorTest extends TestCase
{
    public function test_group_a00_calculates_correctly()
    {
        $student = new Student([
            'toan' => 8.0,
            'vat_li' => 9.0,
            'hoa_hoc' => 7.5,
        ]);

        $calculator = new GroupA00Calculator();
        $total = $calculator->calculate($student);

        $this->assertEquals(24.5, $total);
    }

    public function test_group_a00_returns_null_when_subject_missing()
    {
        $student = new Student([
            'toan' => 8.0,
            'vat_li' => null,
            'hoa_hoc' => 7.5,
        ]);

        $calculator = new GroupA00Calculator();
        $total = $calculator->calculate($student);

        $this->assertNull($total);
    }

    public function test_group_a01_calculates_correctly()
    {
        $student = new Student([
            'toan' => 9.0,
            'vat_li' => 8.5,
            'ngoai_ngu' => 7.0,
        ]);

        $calculator = new GroupA01Calculator();
        $total = $calculator->calculate($student);

        $this->assertEquals(24.5, $total);
    }

    public function test_group_b00_calculates_correctly()
    {
        $student = new Student([
            'toan' => 8.0,
            'hoa_hoc' => 9.0,
            'sinh_hoc' => 7.5,
        ]);

        $calculator = new GroupB00Calculator();
        $total = $calculator->calculate($student);

        $this->assertEquals(24.5, $total);
    }

    public function test_has_required_subjects_returns_true_when_all_present()
    {
        $student = new Student([
            'toan' => 8.0,
            'vat_li' => 9.0,
            'hoa_hoc' => 7.5,
        ]);

        $calculator = new GroupA00Calculator();
        
        $this->assertTrue($calculator->hasRequiredSubjects($student));
    }

    public function test_has_required_subjects_returns_false_when_one_missing()
    {
        $student = new Student([
            'toan' => 8.0,
            'vat_li' => null,
            'hoa_hoc' => 7.5,
        ]);

        $calculator = new GroupA00Calculator();
        
        $this->assertFalse($calculator->hasRequiredSubjects($student));
    }

    public function test_get_name_returns_correct_name()
    {
        $calculator = new GroupA00Calculator();
        
        $this->assertEquals('A00', $calculator->getName());
    }

    public function test_get_required_subjects_returns_correct_subjects()
    {
        $calculator = new GroupA00Calculator();
        $subjects = $calculator->getRequiredSubjects();

        $this->assertCount(3, $subjects);
        $this->assertContains('toan', $subjects);
        $this->assertContains('vat_li', $subjects);
        $this->assertContains('hoa_hoc', $subjects);
    }
}
