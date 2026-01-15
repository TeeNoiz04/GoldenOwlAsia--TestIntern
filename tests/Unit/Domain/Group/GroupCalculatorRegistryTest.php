<?php

namespace Tests\Unit\Domain\Group;

use Tests\TestCase;
use App\Domain\Group\GroupCalculatorRegistry;
use App\Domain\Group\Contracts\GroupCalculatorInterface;

class GroupCalculatorRegistryTest extends TestCase
{
    private GroupCalculatorRegistry $registry;

    protected function setUp(): void
    {
        parent::setUp();
        $this->registry = new GroupCalculatorRegistry();
    }

    public function test_registry_contains_all_groups()
    {
        $groups = $this->registry->all();

        $this->assertCount(6, $groups);
        $this->assertArrayHasKey('A00', $groups);
        $this->assertArrayHasKey('A01', $groups);
        $this->assertArrayHasKey('B00', $groups);
        $this->assertArrayHasKey('C00', $groups);
        $this->assertArrayHasKey('D01', $groups);
        $this->assertArrayHasKey('D07', $groups);
    }

    public function test_get_returns_calculator_when_exists()
    {
        $calculator = $this->registry->get('A00');

        $this->assertInstanceOf(GroupCalculatorInterface::class, $calculator);
        $this->assertEquals('A00', $calculator->getName());
    }

    public function test_get_returns_null_when_not_exists()
    {
        $calculator = $this->registry->get('NONEXISTENT');

        $this->assertNull($calculator);
    }

    public function test_get_group_names_returns_all_names()
    {
        $names = $this->registry->getGroupNames();

        $this->assertCount(6, $names);
        $this->assertContains('A00', $names);
        $this->assertContains('A01', $names);
        $this->assertContains('B00', $names);
    }

    public function test_all_calculators_implement_interface()
    {
        foreach ($this->registry->all() as $calculator) {
            $this->assertInstanceOf(GroupCalculatorInterface::class, $calculator);
        }
    }
}
