<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Traits\Notify;
use App\Traits\System;
use Axiom\Rules\StrongPassword;
use Axiom\Rules\TelephoneNumber;
use Axiom\Rules\WithoutWhitespace;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class NewUserProfileUpdate extends Component
{
    use System, Notify;

    /** @var string */
    public $fname;
    /** @var string */
    public $lname;
    /** @var string */
    public $title;
    /** @var string|null */
    public $phone = null;
    /** @var string */
    public $username;
    /** @var string */
    public $password;
    /** @var string */
    public $password_confirmation;

    protected function rules(): array
    {
        return [
            'title' => 'bail|required|in:Mr,Mrs,Ms,Dr,Prof,Eng,Miss',
            'fname' => 'bail|required|string|max:50',
            'lname' => 'bail|required|string|max:50',
            'username' => 'bail|required|alpha_num|string|max:15|min:4|unique:users,username',
            'phone' => ['bail', 'nullable', 'max:20', new TelephoneNumber],
            'password' => ['bail', 'required', 'confirmed', new WithoutWhitespace, 'different:current_password', new StrongPassword],
            'password_confirmation' => 'bail|required',
        ];
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.new-user-profile-update');
    }

    public function updateProfile(int $id)
    {
        abort_unless($id == auth()->user()->id, 404);

        $this->validate();

        try {
            User::where('id', auth()->user()->id)
                ->update([
                    'title' => $this->title,
                    'name' => $this->fname . ' ' . $this->lname,
                    'username' => Str::lower($this->username),
                    'phone' => $this->phone,
                    'password' => Hash::make($this->password),
                    'email_verified_at' => now(),
                    'newuser' => 0,
                ]);
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors($th->getMessage())->withInput();
        }

        $user = User::find(auth()->user()->id);
        $message = 'Hi ' . $this->title . ' ' . $this->fname . ', <strong class="text-success">Welcome to the DMIEsys</strong>. To update your profile image, click your username at the top right corner and go to settings.';
        $this->notifyUser($user, $message);

        return redirect()->route('dashboard');
    }
}
