<?php

namespace App\Http\Livewire;

use App\Mail\WelcomeNewUser;
use App\Models\User;
use App\Traits\System;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class AddNewUser extends Component
{
    use System;

    /**
     * @var string
     */
    public $email;

    /**
     * @var int
     */
    public $role;

    /**
     * @var array
     */
    protected $rules = ([
        'email' => 'required|email|unique:users',
        'role' => 'required|integer',
    ]);

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.add-new-user', [
            'roles' => Role::where('name', '!=', 'Super Admin')->orderBy('id')->get(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitForm()
    {
        abort_unless(($this->can('add user')), 404);

        $this->validate();

        $username = 'user' . rand(1000, 9999);
        $password = Str::random(6) . rand(1, 99);
        $role = Role::find($this->role);

        DB::beginTransaction();
        try {
            User::create([
                'email' => $this->email,
                'username' => $username,
                'password' => Hash::make($password),
            ]);

            $body = [
                'role' => $role['name'],
                'username' => $username,
                'password' => $password,
                'url' => config('app.url')
            ];

            $newUser = User::where('username', $username)->first();
            $newUser->assignRole($role['name']);

            Mail::to($this->email)->send(new WelcomeNewUser($body));

            DB::commit();

            $this->passed($this->email . ' new user has added to the system.');
        } catch (\Throwable $th) {
            DB::rollback();
            $this->failed($th);
            session()->flash('error', 'There was a problem, please check the logs to see more about this!');
            return back();
        }

        session()->flash('success', 'User added to the system. They\'ll get a email with the instructions.');
        return back();
    }
}
