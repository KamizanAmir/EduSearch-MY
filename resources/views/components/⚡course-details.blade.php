<?php

use Livewire\Component;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public Course $course;
    public bool $isSaved = false;

    public function mount(Course $course)
    {
        $this->course = $course->load(['institution', 'studyLevel']);

        if (Auth::check()) {
            $this->isSaved = Auth::user()->savedCourses()->where('course_id', $this->course->id)->exists();
        }
    }

    public function toggleSave()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($this->isSaved) {
            $user->savedCourses()->detach($this->course->id);
            $this->isSaved = false;
        } else {
            $user->savedCourses()->attach($this->course->id);
            $this->isSaved = true;
        }
    }
};
?>

<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="/" wire:navigate class="text-blue-600 hover:text-blue-800 flex items-center text-sm font-medium">
            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Back to Directory
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-8 border-b border-gray-200">
            <div class="flex justify-between items-start">
                <div>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-4">
                        {{ $course->studyLevel->name }}
                    </span>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $course->name }}</h1>
                    <p class="text-lg text-gray-600">{{ $course->institution->name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500 mb-1">Estimated Fee</p>
                    <p class="text-2xl font-bold text-gray-900">RM {{ number_format($course->estimated_fee) }}</p>
                </div>
            </div>
        </div>

        <div class="p-8 bg-gray-50">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Course Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Institution Details</h3>
                    <p class="text-gray-900 font-medium">{{ $course->institution->name }}</p>
                    <p class="text-gray-600 text-sm mt-1">{{ $course->institution->type }} Institution</p>
                    <p class="text-gray-600 text-sm mt-1">Located in {{ $course->institution->state }}</p>
                    <div class="mt-4 text-gray-700 text-sm">
                        {{ $course->institution->description }}
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Program Details</h3>
                    <ul class="space-y-3 mt-2">
                        <li class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="text-gray-600 text-sm">Study Level</span>
                            <span class="font-medium text-gray-900 text-sm">{{ $course->studyLevel->name }}</span>
                        </li>
                        <li class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="text-gray-600 text-sm">Duration</span>
                            <span class="font-medium text-gray-900 text-sm">{{ $course->duration_months }} Months</span>
                        </li>
                        <li class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="text-gray-600 text-sm">Total Estimated Fee</span>
                            <span class="font-medium text-gray-900 text-sm">RM
                                {{ number_format($course->estimated_fee) }}</span>
                        </li>
                    </ul>
                    <div class="mt-6 flex gap-4">
                        <button
                            class="w-1/2 bg-blue-600 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-700 transition duration-150 shadow-sm">
                            Apply Now
                        </button>
                        <button wire:click="toggleSave"
                            class="w-1/2 font-bold py-3 px-4 rounded-md transition duration-150 shadow-sm {{ $isSaved ? 'bg-gray-200 text-gray-800 hover:bg-gray-300' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                            {{ $isSaved ? '★ Course Saved' : '☆ Save Course' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
