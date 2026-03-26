<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Course;
use App\Models\StudyLevel;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $selectedLevel = '';
    public $maxFee = 100000;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedLevel()
    {
        $this->resetPage();
    }

    public function updatingMaxFee()
    {
        $this->resetPage();
    }

    public function with(): array
    {
        $levels = StudyLevel::all();

        $courses = Course::with(['institution', 'studyLevel'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')->orWhereHas('institution', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedLevel, function ($query) {
                $query->where('study_level_id', $this->selectedLevel);
            })
            ->where('estimated_fee', '<=', $this->maxFee)
            ->paginate(12);

        return [
            'courses' => $courses,
            'levels' => $levels,
        ];
    }
};
?>

<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8 bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Filter Courses in Malaysia</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div>
                <label class="block text-sm font-medium text-gray-700">Search Course or University</label>
                <input wire:model.live="search" type="text" placeholder="e.g. Computer Science..."
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Study Level</label>
                <select wire:model.live="selectedLevel"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                    <option value="">All Levels</option>
                    @foreach ($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Max Estimated Fee: RM
                    {{ number_format($maxFee) }}</label>
                <input wire:model.live="maxFee" type="range" min="1000" max="150000" step="1000"
                    class="mt-2 w-full">
            </div>

        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($courses as $course)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col">
                <div class="p-6 flex-grow">
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">
                        {{ $course->studyLevel->name }}
                    </span>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $course->name }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ $course->institution->name }}</p>

                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span class="flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $course->institution->state }}
                        </span>
                        <span>{{ $course->duration_months }} Months</span>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                    <span class="font-bold text-gray-900">RM {{ number_format($course->estimated_fee) }}</span>
                    <button class="text-sm font-medium text-blue-600 hover:text-blue-500">View Details</button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $courses->links() }}
    </div>
</div>
