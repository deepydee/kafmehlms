<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
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
    public $upload;

    public function rules()
    {
        return [
            'editing.username' => 'required',
            'editing.email' => 'required',
            'editing.password' => 'required',
            'editing.user_role' => 'required|in:'.collect(User::ROLES)
                ->keys()
                ->implode(','),
            'upload' => 'nullable|image|max:1024',
        ];
    }

    public function mount() { $this->editing = $this->makeBlankUser(); }

    public function makeBlankUser()
    {
        return User::make(['username' => '', ]);
    }

    public function create()
    {
        if ($this->editing->getKey()) $this->editing = $this->makeBlankUser();
        $this->showEditModal = true;
    }

    public function edit(User $user)
    {
        if ($this->editing->isNot($user)) $this->editing = $user;
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();
        $this->editing->password = Hash::make($this->editing->password);
        $this->editing->save();

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
