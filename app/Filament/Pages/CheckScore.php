<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use App\Domain\Group\GroupA00;
use App\Domain\Group\GroupA01;
use App\Domain\Group\GroupB00;
use App\Domain\Group\GroupC00;
use App\Domain\Group\GroupD01;
use App\Domain\Group\GroupD07;

class CheckScore extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Check Score';
    protected static ?string $title = 'Check Student Score';
    protected static string $view = 'filament.pages.check-score';
    public ?string $registration_number = null;

    public ?Student $student = null;

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
        $this->student = Student::where(
            'sbd',
            $this->registration_number
        )->first();
    }

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
    public function getTotalGroupB00Property(): ?float
    {
        if (!$this->student || ($this->student->hoa_hoc == null) || ($this->student->sinh_hoc == null)) {
            return null;
        }

         return GroupB00::total($this->student);
    }
    public function getTotalGroupC00Property(): ?float
    {
        if (!$this->student || ($this->student->lich_su == null) || ($this->student->dia_li == null)) {
            return null;
        }

         return GroupC00::total($this->student);
    }
    public function getTotalGroupD01Property(): ?float
    {
        if (!$this->student) {
            return null;
        }

         return GroupD01::total($this->student);
    }
    public function getTotalGroupD07Property(): ?float
    {
        if (!$this->student || ($this->student->hoa_hoc == null)) {
            return null;
        }

         return GroupD07::total($this->student);
    }

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
