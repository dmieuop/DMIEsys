<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Traits\Notify;
use App\Traits\System;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UpdateUserRole extends Component
{
    use System, Notify;

    /** @var \Illuminate\Database\Eloquent\Collection */
    public $roles;
    /** @var \Illuminate\Database\Eloquent\Collection */
    public $role;
    /** @var array */
    public $user;
    /** @var \Illuminate\Database\Eloquent\Collection */
    public $activeusers;

    /** @var array */
    protected $rules = ([
        'user' => 'required|exists:users,id',
        'role' => 'required|exists:roles,name',
    ]);

    public function mount(): void
    {
        $this->activeusers = User::active()->get(['id', 'title', 'name']);
        $this->roles = Role::where('name', '<>', 'Super Admin')->where('name', '<>', 'Head of the Department')->get();
    }
    public function render(): \Illuminate\View\View
    {
        return view('livewire.update-user-role');
    }

    public function submitForm(): \Illuminate\Http\RedirectResponse
    {
        abort_unless(($this->can('change user role')), 404);

        $this->validate();

        $user = User::find($this->user);
        try {
            $user->syncRoles($this->role);
            $this->passed($user->name . '\'s role was changed to the ' . $this->role);
        } catch (\Throwable $th) {
            $this->failed($th);
            session()->flash('error', 'There was a problem, please check the logs to see more about this!');
            return back();
        }

        $message = 'Your role was changed to the ' . $this->role . ' by the ' . auth()->user()->title . ' ' . auth()->user()->name;

        $this->notifyUser($user, $message);

        session()->flash('success', 'User permission changed!');
        return back();
    }
}
