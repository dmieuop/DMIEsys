<?php

namespace App\Http\Controllers\DMIEsys;

use App\Models\User;
use Axiom\Rules\DisposableEmail;
use Axiom\Rules\TelephoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $users = User::active()->get(['id', 'title', 'name', 'email', 'newuser']);

        return view('dmiesys.human_resource.users', compact('users'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function edit(string $username)
    {
        abort_unless($username == auth()->user()->username, 404);

        return view('dmiesys.general.profile');
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(int $id, Request $request)
    {

        if ($request->_type == 'profile_update_request') {
            abort_unless($id == auth()->user()->id, 404);
            $request->validate([
                'title' => 'required|in:Mr,Miss,Mrs,Dr,Prof,Ms,Eng',
                'name' => 'required|string|max:100',
                'email' => ['required', 'email', new DisposableEmail, 'max:50'],
                'phone' => ['nullable', new TelephoneNumber],
                'profilePicture' => 'bail|nullable|image|max:1024|dimensions:min_width=300,min_height=300'
            ]);

            $photoname = auth()->user()->profile_photo_path;

            if ($request->hasFile('profilePicture')) {
                if ($photoname) {
                    try {
                        if (File::exists(config('settings.system.path') . 'storage/profile-pictures/' . $photoname)) {
                            File::delete(config('settings.system.path') . 'storage/profile-pictures/' . $photoname);
                        }
                    } catch (\Throwable $th) {
                        $this->failed($th);
                    }
                }
                $extention = $request->file('profilePicture')->getClientOriginalExtension();
                $photoname = md5(Str::random(20)) . '.' . $extention;
                Image::make($request->file('profilePicture'))->fit(300)->save('storage/profile-pictures/' . $photoname);
            }

            try {
                $user = User::where('id', auth()->user()->id)->first();
                $user->title = $request->title;
                $user->name = $request->name;
                $user->phone = $request->phone;
                $user->profile_photo_path = $photoname;
                $user->save();
                $this->passed('User updated the profile');
            } catch (\Throwable $th) {
                $this->failed($th);
                return back()->withErrors($th->getMessage())->withInput();
            }
            try {
                if (auth()->user()->email != $request->email) {
                    $user = User::findOrFail(auth()->user()->id);
                    $user->newEmail($request->email);
                    $user->save();
                    $this->passed('User updated the email');
                    return back()->with('toast_success', 'Please verify the new email address to get it updated.');
                }
            } catch (\Throwable $th) {
                $this->failed($th);
                return back()->withErrors($th->getMessage())->withInput();
            }
            return back()->with('toast_success', 'Profile updated!');
        } else return back()->withErrors('Something went wrong');
    }

    /**
     * @param int $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $user_id)
    {
        abort_unless(($this->can('deactivate user')), 404);
        try {
            $user = User::findOrFail($user_id);
            $user->delete();
        } catch (\Throwable $th) {
            $this->failed($th);
            return back()->withErrors("There was a problem, please check the logs to see more about this!");
        }
        $this->passed($user->name . ' was deleted');
        return back()->with('toast_success', $user->name . '\'s account deleted successfully!');
    }

    public function seeTheUpdates()
    {
        $user = User::findOrFail(auth()->user()->id);
        $user->has_update_notification = 0;
        $user->save();

        return redirect()->route('changelog');
    }
}
