# Architecture Documentation

## Overview
This project follows **Domain-Driven Design (DDD)** principles with a clean architecture approach.

## Folder Structure

```
app/
├── Domain/                 # Business logic layer (framework-agnostic)
│   ├── Group/             # Group score calculations
│   │   ├── Contracts/     # Interfaces
│   │   ├── Calculators/   # Concrete implementations
│   │   ├── AbstractGroupCalculator.php
│   │   └── GroupCalculatorRegistry.php
│   ├── Score/             # Score classification
│   │   └── ScoreClassifier.php
│   └── Statistics/        # Statistical calculations
│       ├── Contracts/
│       ├── AbstractGroupStatisticsCalculator.php
│       ├── ScienceGroupStatisticsCalculator.php
│       ├── SocialGroupStatisticsCalculator.php
│       ├── SubjectStatisticsCalculator.php
│       ├── SubjectStatisticsService.php
│       └── SubjectConfig.php
├── Models/                # Eloquent models
├── Jobs/                  # Background jobs
├── Filament/             # UI layer (Admin panel)
└── Http/                 # HTTP layer
```

## Design Patterns Applied

### 1. Strategy Pattern
**Used in:** Group Calculators
- **Interface:** `GroupCalculatorInterface`
- **Abstract:** `AbstractGroupCalculator`
- **Concrete:** `GroupA00Calculator`, `GroupA01Calculator`, etc.

**Benefits:**
- Easy to add new groups without modifying existing code
- Each group calculation is isolated and testable
- Follows Open/Closed Principle

### 2. Registry Pattern
**Used in:** `GroupCalculatorRegistry`
- Centralizes access to all group calculators
- Makes it easy to iterate through all groups
- Single source of truth for available groups

### 3. Template Method Pattern
**Used in:** `AbstractGroupCalculator`, `AbstractGroupStatisticsCalculator`
- Base class defines the algorithm structure
- Subclasses provide specific implementations
- Reduces code duplication

### 4. Dependency Injection
**Used throughout the application**
- `SubjectStatisticsService` injects `SubjectStatisticsCalculator`
- Controllers and Jobs receive dependencies via constructor
- Improves testability and flexibility

## SOLID Principles

### Single Responsibility Principle (SRP) ✅
Each class has one reason to change:
- `ScoreClassifier`: Only handles score classification
- `SubjectStatisticsCalculator`: Only calculates statistics
- `GroupA00Calculator`: Only calculates Group A00 scores

### Open/Closed Principle (OCP) ✅
- Classes are open for extension but closed for modification
- Add new groups by creating new Calculator classes
- No need to modify existing code

### Liskov Substitution Principle (LSP) ✅
- All `GroupCalculatorInterface` implementations can be used interchangeably
- Abstract classes ensure consistent behavior

### Interface Segregation Principle (ISP) ✅
- Interfaces are small and focused
- `GroupCalculatorInterface` has only necessary methods

### Dependency Inversion Principle (DIP) ✅
- High-level modules depend on abstractions (interfaces)
- `SubjectStatisticsService` depends on `SubjectStatisticsCalculator`

## How to Add New Features

### Adding a New Group
1. Create new calculator: `app/Domain/Group/Calculators/GroupXXXCalculator.php`
2. Extend `AbstractGroupCalculator`
3. Implement `subjects()` and `getName()` methods
4. Register in `GroupCalculatorRegistry`

```php
final class GroupXXXCalculator extends AbstractGroupCalculator
{
    protected function subjects(): array
    {
        return ['subject1', 'subject2', 'subject3'];
    }

    public function getName(): string
    {
        return 'XXX';
    }
}
```

### Adding New Statistics
1. Create new calculator extending `AbstractGroupStatisticsCalculator`
2. Implement `getSubjects()` method
3. Use in your widgets/pages

## Testing Strategy

### Unit Tests
- Test each calculator independently
- Mock dependencies
- Test edge cases (null values, zero division)

### Integration Tests
- Test service layer with real database
- Test complete workflows

### Example Test
```php
class GroupA00CalculatorTest extends TestCase
{
    public function test_calculates_total_correctly()
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

    public function test_returns_null_when_subject_missing()
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
}
```

## Benefits of This Architecture

1. **Maintainability**: Clear separation of concerns
2. **Testability**: Easy to unit test each component
3. **Scalability**: Easy to add new features
4. **Readability**: Self-documenting code structure
5. **Flexibility**: Easy to swap implementations
6. **Type Safety**: Strong typing with interfaces

## Configuration Management

All configuration is centralized:
- **Subjects**: `SubjectConfig::ALL`
- **Groups**: `GroupCalculatorRegistry`
- **Score Levels**: `ScoreClassifier` constants

## Migration Guide

To migrate existing code to new structure:

1. Update CheckScore page to use `GroupCalculatorRegistry`
2. Replace old group classes with new calculators
3. Update widgets to use registry pattern
4. Replace `ScienceGroupCalculator` with `ScienceGroupStatisticsCalculator`
5. Replace `SocialGroupCalculator` with `SocialGroupStatisticsCalculator`

See individual files for detailed implementation examples.
