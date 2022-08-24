<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Courses extends Component
{
    use WithFileUploads;

    public $showEditModal = false;
    public $showDeleteModal = false;
    public Course $editing;
    public $upload;

    public function rules()
    {
        return [
            'editing.title' => 'required|in:'.collect(Course::COURSES)
                ->keys()
                ->implode(','),
            'editing.description' => 'required',
            'editing.start_date' => 'required',
            'upload' => 'nullable|image|max:1024',
        ];
    }

    public function mount() { $this->editing = $this->makeBlankCourse(); }

    public function makeBlankCourse()
    {
        return Course::make(['title' => 'teormex', ]);
    }

    public function create()
    {
        if ($this->editing->getKey()) $this->editing = $this->makeBlankCourse();
        $this->showEditModal = true;
    }

    public function edit(Course $course)
    {
        if ($this->editing->isNot($course)) $this->editing = $course;
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();
        $this->editing->save();

        $this->upload && $this->editing->update([
            'course_image' => $this->upload->store('/', 'thumbs')
        ]);
        
        $this->showEditModal = false;
    }

    public function cancel()
    {
        $this->showEditModal = false;
    }

    public function render()
    {
        Gate::allowIf(fn ($user) => $user->user_role === 'admin' || $user->user_role === 'teacher');
        return view('livewire.courses', [
            'courses' => Course::all(),
        ]);
    }
}
