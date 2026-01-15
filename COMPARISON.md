# So Sánh: Code Cũ vs Code Mới

## 1. Group Calculators

### ❌ Code Cũ (Trước)
```php
// app/Domain/Group/GroupA00.php
final class GroupA00
{
    public static function total(Student $student): float
    {
        return (float) (
            $student->toan
            + $student->vat_li
            + $student->hoa_hoc
        );
    }
}

// app/Domain/Group/GroupA01.php
final class GroupA01
{
    public static function total(Student $student): float
    {
        return (float) (
            $student->toan
            + $student->vat_li
            + $student->ngoai_ngu
        );
    }
}
// ... 6 files tương tự cho các group khác
```

**Vấn đề:**
- ❌ Lặp code (mỗi class giống nhau 95%)
- ❌ Không kiểm tra null values
- ❌ Khó mở rộng (thêm group mới = tạo file mới)
- ❌ Không có interface chung
- ❌ Khó test riêng lẻ

### ✅ Code Mới (Sau)
```php
// Interface chung
interface GroupCalculatorInterface
{
    public function calculate(Student $student): ?float;
    public function getName(): string;
    public function getRequiredSubjects(): array;
    public function hasRequiredSubjects(Student $student): bool;
}

// Abstract class xử lý logic chung
abstract class AbstractGroupCalculator implements GroupCalculatorInterface
{
    abstract protected function subjects(): array;
    
    public function calculate(Student $student): ?float
    {
        if (!$this->hasRequiredSubjects($student)) {
            return null;
        }
        
        $total = 0;
        foreach ($this->subjects() as $subject) {
            $total += $student->$subject ?? 0;
        }
        
        return (float) $total;
    }
    
    // ... common logic
}

// Concrete implementation (chỉ cần khai báo subjects)
final class GroupA00Calculator extends AbstractGroupCalculator
{
    protected function subjects(): array
    {
        return ['toan', 'vat_li', 'hoa_hoc'];
    }
    
    public function getName(): string
    {
        return 'A00';
    }
}
```

**Lợi ích:**
- ✅ Không lặp code (logic chung ở abstract class)
- ✅ Tự động kiểm tra null values
- ✅ Dễ mở rộng (chỉ cần khai báo subjects)
- ✅ Có interface để test và thay thế
- ✅ Dễ test từng calculator độc lập

---

## 2. Registry Pattern

### ❌ Code Cũ (Không có)
```php
// CheckScore.php - Phải import từng class
use App\Domain\Group\GroupA00;
use App\Domain\Group\GroupA01;
use App\Domain\Group\GroupB00;
// ...

// Phải viết method riêng cho từng group
public function getTotalGroupA00Property(): ?float
{
    if (!$this->student || ($this->student->vat_li == null) || ($this->student->hoa_hoc == null)) {
        return null;
    }
    return GroupA00::total($this->student);
}

public function getTotalGroupA01Property(): ?float
{
    if (!$this->student || ($this->student->hoa_hoc == null)) {
        return null;
    }
    return GroupA01::total($this->student);
}
// ... 6 methods tương tự
```

**Vấn đề:**
- ❌ Lặp lại code 6 lần
- ❌ Thêm group mới = thêm method mới
- ❌ Logic kiểm tra null không nhất quán
- ❌ Khó maintain

### ✅ Code Mới (Sau)
```php
// GroupCalculatorRegistry.php
class GroupCalculatorRegistry
{
    private array $calculators = [];
    
    public function __construct()
    {
        $this->calculators = [
            'A00' => new GroupA00Calculator(),
            'A01' => new GroupA01Calculator(),
            // ... các group khác
        ];
    }
    
    public function get(string $groupName): ?GroupCalculatorInterface
    {
        return $this->calculators[$groupName] ?? null;
    }
    
    public function all(): array
    {
        return $this->calculators;
    }
}

// CheckScoreRefactored.php
class CheckScoreRefactored extends Page
{
    protected GroupCalculatorRegistry $registry;
    public array $groupScores = [];
    
    public function boot(GroupCalculatorRegistry $registry): void
    {
        $this->registry = $registry;
    }
    
    protected function calculateAllGroupScores(): void
    {
        $this->groupScores = [];
        
        // Chỉ cần 1 vòng lặp cho TẤT CẢ các group!
        foreach ($this->registry->all() as $groupName => $calculator) {
            $this->groupScores[$groupName] = $calculator->calculate($this->student);
        }
    }
    
    public function getGroupScore(string $groupName): ?float
    {
        return $this->groupScores[$groupName] ?? null;
    }
}
```

**Lợi ích:**
- ✅ Chỉ 1 method thay vì 6 methods
- ✅ Thêm group mới: chỉ sửa Registry, không sửa CheckScore
- ✅ Logic nhất quán
- ✅ Dễ maintain và mở rộng

---

## 3. Statistics Calculators

### ❌ Code Cũ (Trước)
```php
// ScienceGroupCalculator.php
class ScienceGroupCalculator
{
    private const SCIENCE_SUBJECTS = ['vat_li', 'hoa_hoc', 'sinh_hoc'];
    
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
        
        $arrayTotalSubject = SubjectStatistic::whereIn('subject', self::SCIENCE_SUBJECTS)
            ->selectRaw('subject, SUM(excellent + good + average) as total')
            ->groupBy('subject')
            ->get();
        
        if ($arrayTotalSubject->isEmpty()) {
            return 0;
        }
        
        $maxTotal = $arrayTotalSubject->max('total');
        return round(($maxTotal / $totalStudents) * 100, 2);
    }
}

// SocialGroupCalculator.php
class SocialGroupCalculator
{
    private const SOCIAL_SUBJECTS = ['lich_su', 'dia_ly', 'gdcd'];
    
    // GIỐNG HỆT code trên, chỉ khác mỗi SOCIAL_SUBJECTS
    public function getTotalStudent(): int { ... }
    public function calculatePercent(): float { ... }
}
```

**Vấn đề:**
- ❌ Code lặp lại 100%
- ❌ Vi phạm DRY principle nghiêm trọng
- ❌ Sửa logic ở 1 chỗ phải sửa ở chỗ kia

### ✅ Code Mới (Sau)
```php
// Abstract class chứa logic chung
abstract class AbstractGroupStatisticsCalculator implements GroupStatisticsCalculatorInterface
{
    abstract public function getSubjects(): array;
    
    public function getTotalStudent(): int
    {
        return Student::count();
    }
    
    public function calculatePercent(): float
    {
        $totalStudents = $this->getTotalStudent();
        if ($totalStudents === 0) {
            return 0;
        }
        
        $arrayTotalSubject = SubjectStatistic::whereIn('subject', $this->getSubjects())
            ->selectRaw('subject, SUM(excellent + good + average) as total')
            ->groupBy('subject')
            ->get();
        
        if ($arrayTotalSubject->isEmpty()) {
            return 0;
        }
        
        $maxTotal = $arrayTotalSubject->max('total');
        return round(($maxTotal / $totalStudents) * 100, 2);
    }
}

// Concrete implementations (CHỈ CẦN 4 DÒNG!)
final class ScienceGroupStatisticsCalculator extends AbstractGroupStatisticsCalculator
{
    public function getSubjects(): array
    {
        return ['vat_li', 'hoa_hoc', 'sinh_hoc'];
    }
}

final class SocialGroupStatisticsCalculator extends AbstractGroupStatisticsCalculator
{
    public function getSubjects(): array
    {
        return ['lich_su', 'dia_ly', 'gdcd'];
    }
}
```

**Lợi ích:**
- ✅ Giảm code từ 80 dòng xuống 8 dòng!
- ✅ Sửa logic chỉ ở 1 chỗ
- ✅ Thêm group mới chỉ cần 4 dòng code
- ✅ Dễ test hơn

---

## 4. Configuration Management

### ❌ Code Cũ (Trước)
```php
// Jobs/RecalculateSubjectStatistics.php
protected array $subjects = [
    'toan', 'ngu_van', 'ngoai_ngu', 'vat_li', 'hoa_hoc', 
    'sinh_hoc', 'lich_su', 'dia_li', 'gdcd',
];

// Domain/Statistics/Subjects.php
class Subjects
{
    public const ALL = [
        'toan' => 'Math',
        'vat_li' => 'Physics',
        // ...
    ];
}

// Ở nhiều nơi khác cũng có danh sách subjects riêng
```

**Vấn đề:**
- ❌ Danh sách subjects nằm ở nhiều nơi
- ❌ Không có utility methods
- ❌ Khó maintain

### ✅ Code Mới (Sau)
```php
// Domain/Statistics/SubjectConfig.php
final class SubjectConfig
{
    public const ALL = [
        'toan'     => 'Math',
        'vat_li'   => 'Physics',
        // ...
    ];
    
    public static function getAllKeys(): array
    {
        return array_keys(self::ALL);
    }
    
    public static function getDisplayName(string $key): string
    {
        return self::ALL[$key] ?? $key;
    }
    
    public static function exists(string $key): bool
    {
        return array_key_exists($key, self::ALL);
    }
}

// Sử dụng
$subjects = SubjectConfig::getAllKeys(); // Chỉ 1 nguồn duy nhất!
```

**Lợi ích:**
- ✅ Single source of truth
- ✅ Có utility methods tiện dụng
- ✅ Dễ maintain và mở rộng

---

## Tổng Kết

| Tiêu chí | Code Cũ | Code Mới |
|----------|---------|----------|
| **Số dòng code** | ~500 dòng | ~200 dòng |
| **Code lặp lại** | Nhiều | Không có |
| **Khả năng mở rộng** | Khó (phải sửa nhiều file) | Dễ (chỉ thêm 1 class) |
| **Testability** | Khó test | Dễ test với interface |
| **SOLID Principles** | Vi phạm nhiều | Tuân thủ đầy đủ |
| **Maintainability** | Khó maintain | Dễ maintain |
| **Type Safety** | Yếu | Mạnh (với interface) |
| **Documentation** | Không có | Đầy đủ |

## Hướng Dẫn Migration

1. **Bước 1**: Đăng ký Registry vào Service Provider
2. **Bước 2**: Update CheckScore page sử dụng Registry
3. **Bước 3**: Update Widgets sử dụng new Calculator
4. **Bước 4**: Chạy tests để đảm bảo không lỗi
5. **Bước 5**: Xóa các old classes (GroupA00, GroupA01, etc.)

Chi tiết xem trong [ARCHITECTURE.md](ARCHITECTURE.md)
