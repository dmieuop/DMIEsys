<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Traits\Notify;
use App\Traits\System;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesList extends Component
{
    use WithPagination, System, Notify;

    /** @var string|null */
    public $newRole = null;
    /** @var string|null */
    public $role = null;
    /** @var string|null */
    public $user = null;
    /** @var string|null */
    public $userRole = null;
    /** @var object|null */
    public $selectRole = null;
    /** @var object|null */
    public $selectUser = null;

    /** @var array */
    protected $rules = ([
        'newRole' => 'required|string|max:200',
    ]);

    public function render(): \Illuminate\View\View
    {
        return view('livewire.roles-list', [
            'roles' => Role::where('name', '!=', 'Super Admin')->orderBy('id')->paginate(5),
            'all_roles' => Role::where('name', '!=', 'Super Admin')->get(),
            'all_users' => User::active()->get(),
            'permissions' => Permission::orderBy('id')->get(),
        ]);
    }

    public function Submit(): \Illuminate\Http\RedirectResponse
    {
        $this->validate();

        try {
            Role::create([
                'name' => $this->newRole,
            ]);
            $this->passed($this->newRole . ' role created');
            return back()->with('toast_success', 'new role added successfully!');
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors('Something went wrong!');
        }
    }

    public function DeleteRole(int $role_id): \Illuminate\Http\RedirectResponse
    {
        try {
            $role = Role::find($role_id);
            $role->delete();
            $this->passed($role->name . ' role deleted');
            $this->notifyHOD($role->name . ' role deleted by ' . auth()->user()->name);
            return back()->with('toast_success', 'Role deleted successfully!');
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors('Something went wrong!');
        }
    }

    public function updatedRole(): void
    {
        $this->selectRole = Role::find($this->role);
    }

    public function updatedUser(): void
    {
        $this->selectUser = User::find($this->user);
    }

    public function SetPermissionForRole(string $permission): void
    {
        if ($this->selectRole->hasPermissionTo($permission)) {
            $this->selectRole->revokePermissionTo($permission);
            $this->passed($this->selectRole->name . ' lost permission to <b>' . $permission . '</b>');
        } else {
            $this->selectRole->givePermissionTo($permission);
            $this->passed($this->selectRole->name . ' got permission to <b>' . $permission . '</b>');
        }
    }

    public function SetPermissionForUser(string $permission): void
    {
        if ($this->selectUser->hasPermissionTo($permission)) {
            $this->selectUser->revokePermissionTo($permission);
            $this->passed($this->selectUser->name . ' lost permission to <b>' . $permission . '</b>');
            $this->notifyUser($this->selectUser, 'You lost the permission to <b>' . $permission . '</b>');
        } else {
            $this->selectUser->givePermissionTo($permission);
            $this->passed($this->selectUser->name . ' got permission to <b>' . $permission . '</b>');
            $this->notifyUser($this->selectUser, 'Now you have permission to <b>' . $permission . '</b>');
        }
    }
}
