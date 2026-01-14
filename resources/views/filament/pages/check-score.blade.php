<x-filament::page>
    <x-filament::section icon="heroicon-o-magnifying-glass" icon-color="primary">
        <x-slot name="heading">
            Tra cứu điểm thi
        </x-slot>

        {{-- FORM --}}
        <form wire:submit="checkScore" class="flex flex-col sm:flex-row items-start sm:items-end gap-4">
            <div class="w-full sm:max-w-xs">
                {{ $this->form }}
            </div>

            <x-filament::button type="submit" icon="heroicon-m-check-circle" class="w-full sm:w-auto">
                Check Score
            </x-filament::button>
        </form>

        {{-- RESULT --}}
        @if ($student)
           {{-- Sửa mt-8 thành mt-16 để cách xa form hơn --}}
        <div class="mt-6 p-4 rounded-lg bg-danger-50 dark:bg-danger-950/30 border border-danger-200 dark:border-danger-900 dark:text-danger-400 ">
    
                {{-- 1. ĐIỂM CHI TIẾT (1 HÀNG 3 CỘT) --}}
                <div class="pt-8 pb-8">
                    <h3 class="text-lg font-bold text-gray-950 dark:text-white mb-4 flex items-center gap-2">
                        <x-heroicon-m-academic-cap class="w-5 h-5 text-primary-600"/>
                        Điểm chi tiết
                    </h3>
                    
                    {{-- Grid 1 cột trên mobile, 3 cột trên máy tính --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pb-4">
                        @php
                            $subjects = [
                                'Toán' => $student->toan,
                                'Vật lí' => $student->vat_li,
                                'Hóa học' => $student->hoa_hoc,
                                'Sinh học' => $student->sinh_hoc,
                                'Ngữ văn' => $student->ngu_van,
                                'Lịch sử' => $student->lich_su,
                                'Địa lí' => $student->dia_li,
                                'GDCD' => $student->gdcd,
                                'Ngoại ngữ (' . $student->ma_ngoai_ngu . ')' => $student->ngoai_ngu,
                            ];
                        @endphp

                        @foreach($subjects as $label => $score)
                            {{-- Card nằm ngang (flex-row) vì cột rộng hơn --}}
                            <div class="px-4 py-3 rounded-lg bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 flex items-center justify-between hover:border-primary-500 transition duration-300">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">{{ $label }}</span>
                                <span class="text-xl font-bold {{ $score >= 5 ? 'text-success-600 dark:text-success-400' : 'text-danger-600 dark:text-danger-400' }}">
                                    {{ $score !== null ? $score : '-' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="border-t border-gray-200 dark:border-white/10"></div>

                {{-- 2. TỔ HỢP XÉT TUYỂN (1 HÀNG 2 CỘT) --}}
                <div class="pt-8 pb-8">
                    <h3 class=" text-lg font-bold text-gray-950 dark:text-white mb-4 flex items-center gap-2">
                        <x-heroicon-m-trophy class="w-5 h-5 text-warning-500 text-primary-600" />
                        Tổ hợp xét tuyển
                    </h3>

                    {{-- Grid 1 cột trên mobile, 2 cột trên máy tính --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            $groups = [
                                'A00' => $this->totalGroupA00,
                                'A01' => $this->totalGroupA01,
                                'B00' => $this->totalGroupB00,
                                'C00' => $this->totalGroupC00,
                                'D01' => $this->totalGroupD01,
                                'D07' => $this->totalGroupD07,
                            ];
                        @endphp

                        @foreach($groups as $group => $total)
                            <div class="relative overflow-hidden p-4 rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 flex items-center justify-between group">
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">Khối {{ $group }}</span>
                                </div>
                                <div class="z-10">
                                    <span class="text-3xl font-bold text-primary-600 dark:text-primary-400">
                                        {{ $total !== null ? $total : '-' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach

                        {{-- Tổng điểm tất cả --}}
                        <div class="col-span-1 md:col-span-2 p-4 rounded-xl bg-primary-50 dark:bg-primary-900/10 ring-1 ring-primary-500/20 flex items-center justify-between">
                            <span class="text-base font-bold text-primary-800 dark:text-primary-300">Tổng điểm tất cả các môn</span>
                            <span class="text-3xl font-bold text-primary-700 dark:text-primary-400">{{ $this->totalAllSubjects }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($registration_number)
            <div class="mt-6 p-4 rounded-lg bg-danger-50 dark:bg-danger-950/30 border border-danger-200 dark:border-danger-900 text-danger-600 dark:text-danger-400 flex items-center gap-3">
                <x-heroicon-m-exclamation-circle class="w-6 h-6"/>
                <div>
                    <span class="font-bold">Không tìm thấy dữ liệu!</span>
                    <p class="text-sm text-danger-500 dark:text-danger-400/80">Số báo danh: <strong>{{ $registration_number }}</strong></p>
                </div>
            </div>
        @endif
    </x-filament::section>
</x-filament::page>