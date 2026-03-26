<?php

use Livewire\Component;
use App\Models\Institution;
use App\Models\Course;
use App\Models\StudyLevel;

new class extends Component {
    public $instName = '';
    public $instState = '';
    public $instType = '';
    public $instDesc = '';

    public $courseInstId = '';
    public $courseLevelId = '';
    public $courseName = '';
    public $courseDuration = '';
    public $courseFee = '';
    public $editingInstId = null;

    public $successMessage = '';

    public function saveInstitution()
    {
        $this->validate([
            'instName' => 'required|string|max:255',
            'instState' => 'required|string|max:255',
            'instType' => 'required|string|max:255',
            'instDesc' => 'nullable|string',
        ]);

        Institution::create([
            'name' => $this->instName,
            'state' => $this->instState,
            'type' => $this->instType,
            'description' => $this->instDesc,
        ]);

        $this->reset(['instName', 'instState', 'instType', 'instDesc']);
        $this->successMessage = 'Institution added successfully!';
    }

    public function saveCourse()
    {
        $this->validate([
            'courseInstId' => 'required|exists:institutions,id',
            'courseLevelId' => 'required|exists:study_levels,id',
            'courseName' => 'required|string|max:255',
            'courseDuration' => 'required|integer|min:1',
            'courseFee' => 'required|numeric|min:0',
        ]);

        Course::create([
            'institution_id' => $this->courseInstId,
            'study_level_id' => $this->courseLevelId,
            'name' => $this->courseName,
            'duration_months' => $this->courseDuration,
            'estimated_fee' => $this->courseFee,
        ]);

        $this->reset(['courseInstId', 'courseLevelId', 'courseName', 'courseDuration', 'courseFee']);
        $this->successMessage = 'Course added successfully!';
    }

    public function editInstitution($id)
    {
        $inst = Institution::find($id);
        if ($inst) {
            $this->editingInstId = $inst->id;
            $this->instName = $inst->name;
            $this->instState = $inst->state;
            $this->instType = $inst->type;
            $this->instDesc = $inst->description;
        }
    }

    public function updateInstitution()
    {
        $this->validate([
            'instName' => 'required|string|max:255',
            'instState' => 'required|string|max:255',
            'instType' => 'required|string|max:255',
            'instDesc' => 'nullable|string',
        ]);

        if ($this->editingInstId) {
            Institution::find($this->editingInstId)->update([
                'name' => $this->instName,
                'state' => $this->instState,
                'type' => $this->instType,
                'description' => $this->instDesc,
            ]);

            $this->reset(['instName', 'instState', 'instType', 'instDesc', 'editingInstId']);
            $this->successMessage = 'Institution updated successfully!';
        }
    }

    public function cancelEdit()
    {
        $this->reset(['instName', 'instState', 'instType', 'instDesc', 'editingInstId']);
    }

    public function deleteInstitution($id)
    {
        Institution::find($id)?->delete();
        $this->successMessage = 'Institution deleted successfully!';
    }
    public function with(): array
    {
        return [
            'institutions' => Institution::orderBy('name')->get(),
            'studyLevels' => StudyLevel::all(),
        ];
    }
};
?>

<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    @if ($successMessage)
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ $successMessage }}</span>
            <button wire:click="$set('successMessage', '')" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">
                {{ $editingInstId ? 'Edit Institution' : 'Add New Institution' }}</h2>
            <form wire:submit="{{ $editingInstId ? 'updateInstitution' : 'saveInstitution' }}">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Institution Name</label>
                    <input wire:model="instName" type="text"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"
                        required>
                    @error('instName')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                    <select wire:model="instState"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"
                        required>
                        <option value="">Select State</option>
                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                        <option value="Selangor">Selangor</option>
                        <option value="Penang">Penang</option>
                        <option value="Johor">Johor</option>
                        <option value="Perak">Perak</option>
                        <option value="Sabah">Sabah</option>
                        <option value="Sarawak">Sarawak</option>
                    </select>
                    @error('instState')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select wire:model="instType"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"
                        required>
                        <option value="">Select Type</option>
                        <option value="Public">Public</option>
                        <option value="Private">Private</option>
                        <option value="GLC">GLC</option>
                    </select>
                    @error('instType')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea wire:model="instDesc" rows="3"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"></textarea>
                    @error('instDesc')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700 transition duration-150">
                        {{ $editingInstId ? 'Update Institution' : 'Save Institution' }}
                    </button>
                    @if ($editingInstId)
                        <button type="button" wire:click="cancelEdit"
                            class="w-full bg-gray-500 text-white font-bold py-2 px-4 rounded-md hover:bg-gray-600 transition duration-150">
                            Cancel
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Add New Course</h2>
            <form wire:submit="saveCourse">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Institution</label>
                    <select wire:model="courseInstId"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"
                        required>
                        <option value="">Select Institution</option>
                        @foreach ($institutions as $inst)
                            <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                        @endforeach
                    </select>
                    @error('courseInstId')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Study Level</label>
                    <select wire:model="courseLevelId"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"
                        required>
                        <option value="">Select Level</option>
                        @foreach ($studyLevels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                    @error('courseLevelId')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Course Name</label>
                    <input wire:model="courseName" type="text" placeholder="e.g. Bachelor of Computer Science"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"
                        required>
                    @error('courseName')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4 flex gap-4">
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Duration (Months)</label>
                        <input wire:model="courseDuration" type="number" min="1"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"
                            required>
                        @error('courseDuration')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Fee (RM)</label>
                        <input wire:model="courseFee" type="number" min="0" step="0.01"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"
                            required>
                        @error('courseFee')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-green-600 text-white font-bold py-2 px-4 rounded-md hover:bg-green-700 transition duration-150 mt-2">
                    Save Course
                </button>
            </form>
        </div>
    </div>
    <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-bold text-gray-900">Manage Institutions</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            State</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($institutions as $inst)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $inst->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $inst->state }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $inst->type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="editInstitution({{ $inst->id }})"
                                    class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                                <button wire:click="deleteInstitution({{ $inst->id }})"
                                    wire:confirm="Are you sure you want to delete this institution? All its courses will be deleted too."
                                    class="text-red-600 hover:text-red-900">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
