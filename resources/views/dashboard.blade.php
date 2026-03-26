<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Dashboard') }}
            </h2>
            <a href="/" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Browse More Courses &rarr;</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600">Here are the courses you have saved for later.</p>
                </div>
            </div>

            @php
                $savedCourses = Auth::user()
                    ->savedCourses()
                    ->with(['institution', 'studyLevel'])
                    ->get();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($savedCourses as $course)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col">
                        <div class="p-6 flex-grow">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">
                                {{ $course->studyLevel->name }}
                            </span>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $course->name }}</h3>
                            <p class="text-sm text-gray-600 mb-4">{{ $course->institution->name }}</p>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                            <span class="font-bold text-gray-900">RM {{ number_format($course->estimated_fee) }}</span>
                            <a href="{{ route('courses.show', $course->id) }}"
                                class="text-sm font-medium text-blue-600 hover:text-blue-500">View Details</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-8 rounded-lg shadow-sm border border-gray-200 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">No saved courses</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by browsing the directory and saving courses
                            you are interested in.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
