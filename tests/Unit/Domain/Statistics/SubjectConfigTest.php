<?php

namespace Tests\Unit\Domain\Statistics;

use Tests\TestCase;
use App\Domain\Statistics\SubjectConfig;

class SubjectConfigTest extends TestCase
{
    public function test_get_all_keys_returns_array_of_subjects()
    {
        $keys = SubjectConfig::getAllKeys();

        $this->assertIsArray($keys);
        $this->assertCount(9, $keys);
        $this->assertContains('toan', $keys);
        $this->assertContains('vat_li', $keys);
        $this->assertContains('hoa_hoc', $keys);
    }

    public function test_get_display_name_returns_correct_name()
    {
        $this->assertEquals('Math', SubjectConfig::getDisplayName('toan'));
        $this->assertEquals('Physics', SubjectConfig::getDisplayName('vat_li'));
        $this->assertEquals('Chemistry', SubjectConfig::getDisplayName('hoa_hoc'));
    }

    public function test_get_display_name_returns_key_when_not_found()
    {
        $this->assertEquals('nonexistent', SubjectConfig::getDisplayName('nonexistent'));
    }

    public function test_exists_returns_true_for_valid_subject()
    {
        $this->assertTrue(SubjectConfig::exists('toan'));
        $this->assertTrue(SubjectConfig::exists('vat_li'));
    }

    public function test_exists_returns_false_for_invalid_subject()
    {
        $this->assertFalse(SubjectConfig::exists('nonexistent'));
        $this->assertFalse(SubjectConfig::exists('invalid'));
    }

    public function test_all_constant_has_correct_structure()
    {
        $all = SubjectConfig::ALL;

        $this->assertIsArray($all);
        $this->assertArrayHasKey('toan', $all);
        $this->assertIsString($all['toan']);
    }
}
