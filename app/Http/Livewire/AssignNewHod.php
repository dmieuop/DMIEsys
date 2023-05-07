<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Traits\Notify;
use App\Traits\System;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AssignNewHod extends Component
{
    use System, Notify;

    /** @var array */
    protected $rules = ([
        'user' => 'required|exists:users,id',
    ]);

    /** @var int */
    public $user;

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.assign-new-hod', [
            'activelecturers' => User::active()->get(['id', 'title', 'name']),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitForm()
    {
        $currentHOD = User::find(auth()->user()->id);
        abort_unless(($currentHOD->hasRole('Head of the Department')), 404);

        $this->validate();

        $newHOD = User::find($this->user);
        DB::beginTransaction();
        try {
            $currentHOD->syncRoles(['Senior Lecturer']);
            $newHOD->syncRoles(['Head of the Department']);
            $this->RemovePermissionForUser($currentHOD, 'change user role');
            $this->RemovePermissionForUser($currentHOD, 'change user permission');
            $this->RemovePermissionForUser($currentHOD, 'add user');
            $this->SetPermissionForUser($newHOD, 'change user role');
            $this->SetPermissionForUser($newHOD, 'change user permission');
            $this->SetPermissionForUser($newHOD, 'add user');
            $this->passed($newHOD->name . ' was appointed as a new HoD');
        } catch (\Throwable $th) {
            DB::rollback();
            $this->failed($th);
            session()->flash('error', 'There was a problem, please check the logs to see more about this!');
            return back();
        }
        DB::commit();

        $otherUsers = User::where('id', '<>', $this->user)->get();
        $message = $newHOD->title . ' ' . $newHOD->name . ' was appointed as the new Head of the Department.';
        $this->notifyUsers($otherUsers, $message);
        $this->notifyUser($newHOD, '<strong class="text-pink-600">Congratulations</strong> for you becoming the new Head of the Department.');
        return redirect()->route('dashboard');
    }

    public function SetPermissionForUser(User $selectUser, string $permission): void
    {
        if (!$selectUser->hasPermissionTo($permission)) {
            $selectUser->givePermissionTo($permission);
            $this->passed($selectUser->name . ' got permission to <b>' . $permission . '</b>');
            $this->notifyUser($selectUser, 'Now you have permission to <b>' . $permission . '</b>');
        }
    }

    public function RemovePermissionForUser(User $selectUser, string $permission): void
    {
        if ($selectUser->hasPermissionTo($permission)) {
            $selectUser->revokePermissionTo($permission);
            $this->passed($selectUser->name . ' lost permission to <b>' . $permission . '</b>');
            $this->notifyUser($selectUser, 'You lost the permission to <b>' . $permission . '</b>');
        }
    }
}
