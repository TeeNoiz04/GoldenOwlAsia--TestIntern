<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use App\Domain\Group\GroupCalculatorRegistry;

class CheckScoreRefactored extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Search Score';
    protected static ?string $title = 'Search Student Score';
    protected static string $view = 'filament.pages.check-score-refactored';
    
    public ?string $registration_number = null;
    public ?Student $student = null;
    public array $groupScores = [];

    protected GroupCalculatorRegistry $registry;

    public function boot(GroupCalculatorRegistry $registry): void
    {
        $this->registry = $registry;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('registration_number')
                    ->label('Registration Number')
                    ->required()
                    ->maxLength(50),
            ]);
    }

    public function checkScore(): void
    {
        $this->student = Student::where('sbd', $this->registration_number)->first();
        
        if ($this->student) {
            $this->calculateAllGroupScores();
        }
    }

    protected function calculateAllGroupScores(): void
    {
        $this->groupScores = [];
        
        foreach ($this->registry->all() as $groupName => $calculator) {
            $this->groupScores[$groupName] = $calculator->calculate($this->student);
        }
    }

    /**
     * Get score for a specific group.
     *
     * @param string $groupName
     * @return float|null
     */
    public function getGroupScore(string $groupName): ?float
    {
        return $this->groupScores[$groupName] ?? null;
    }

    /**
     * Get all group scores.
     *
     * @return array
     */
    public function getAllGroupScores(): array
    {
        return $this->groupScores;
    }

    /**
     * Calculate total of all subjects.
     *
     * @return float|null
     */
    public function getTotalAllSubjectsProperty(): ?float
    {
        if (!$this->student) {
            return null;
        }

        return ($this->student->toan ?? 0)
            + ($this->student->ngu_van ?? 0)
            + ($this->student->ngoai_ngu ?? 0)
            + ($this->student->vat_li ?? 0)
            + ($this->student->hoa_hoc ?? 0)
            + ($this->student->sinh_hoc ?? 0)
            + ($this->student->lich_su ?? 0)
            + ($this->student->dia_li ?? 0)
            + ($this->student->gdcd ?? 0);
    }
}
