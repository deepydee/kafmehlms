<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Users extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithFileUploads;

    public $showEditModal = false;
    public $showDeleteModal = false;
    public User $editing;
    public Teacher $teacher;
    public Student $student;
    public $upload;

    public function rules()
    {
        $teacher_rules = [
            'teacher.position' => 'required',
            'teacher.cathedra' => 'required',
        ];

        $student_rules = [
            'student.course' => 'required',
            'student.faculty' => 'required',
            'student.group' => 'required',
        ];

        $rules = [
            'editing.username' => 'required',
            'editing.email' => 'required',
            'editing.password' => 'required',
            'editing.user_role' => 'required|in:'.collect(User::ROLES)
                ->keys()
                ->implode(','),
            'upload' => 'nullable|image|max:1024',
        ];

        if ($this->editing->user_role == 'teacher') {
            $rules = array_merge($rules, $teacher_rules);
        }

        if ($this->editing->user_role == 'student') {
            $rules = array_merge($rules, $student_rules);
        }
        // dd($rules);
        return $rules;
    }

    public function mount() { 
        $this->editing = $this->makeBlankUser();
        $this->teacher = $this->makeBlankTeacher();
        $this->student = $this->makeBlankStudent();
    }

    public function makeBlankUser()
    {
        return User::make(['username' => '', ]);
    }

    public function makeBlankTeacher()
    {
        return Teacher::make();
    }

    public function makeBlankStudent()
    {
        return Student::make();
    }

    public function create()
    {
        if ($this->editing->getKey()) {
            $this->editing = $this->makeBlankUser();
            $this->teacher = $this->makeBlankTeacher();
            $this->student = $this->makeBlankStudent();
        }
        $this->showEditModal = true;
    }

    public function edit(User $user)
    {
        if ($this->editing->isNot($user)) {
            $this->editing = $this->makeBlankUser();
            $this->teacher = $this->makeBlankTeacher();
            $this->student = $this->makeBlankStudent();
        }
        $this->showEditModal = true;
    }

    public function delete(User $user)
    {
        $user->delete();
    }

    public function save()
    {
        
        $this->validate();
        $this->editing->password = Hash::make($this->editing->password);
        $this->editing->save();
        
        if ($this->editing->user_role == 'teacher') {
            $this->teacher->user_id = $this->editing->id;
            $this->teacher->save();
        }

        if ($this->editing->user_role == 'student') {
            $this->student->user_id = $this->editing->id;
            $this->student->save();
        }

        $folder = date('Y-m-d');
        $this->upload && $this->editing->update([
            'avatar' => $this->upload->store("/$folder", 'avatars')
        ]);
        $this->showEditModal = false;
    }

    public function cancel()
    {
        $this->showEditModal = false;
    }

    public function render()
    {
        if ($this->selectAll) {
            $this->selectPageRows();
        }
        Gate::allowIf(fn ($user) => $user->user_role === 'admin');
        return view('livewire.users', [
            'users' => User::all(),
        ]);
    }
}
