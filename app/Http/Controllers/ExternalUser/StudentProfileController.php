<?php

namespace App\Http\Controllers\ExternalUser;

use App\Mail\RequestExternalUserAccessToken;
use App\Models\ExternalUserAccessToken;
use App\Models\Student;
use App\Traits\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class StudentProfileController
{
    use Cookie;

    public function index()
    {
        return view('auth.student-login');
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'batch' => 'required_if:category,undergraduate|starts_with:E|max:3|alpha_num',
            'student_id' => 'required_if:category,undergraduate|starts_with:E|max:6|alpha_num',
            'email' => 'required|email'
        ])->validate();

        $category = 'student';

        $old_access_token = ExternalUserAccessToken::where('validity', 1)
            ->where('request_email', $request->email)
            ->where('created_at', '>=', now()->subHours(2))->first();

        if (!is_null($old_access_token)) return back()->withErrors('Please wait before submitting another request.');


        $student = Student::where('student_id', $request->student_id)->first();
        if ($student->email == $request->email) {

            $access_token = hash('sha512', Str::random(50));

            $token = new ExternalUserAccessToken();
            $token->category = $category;
            $token->request_email = $request->email;
            $token->token = $access_token;
            $token->save();

            $data = [
                'name' => $student->name,
                'url' => config('app.url') . '/student-login/' . $access_token . '/edit',
            ];

            Mail::to($request->email)->send(new RequestExternalUserAccessToken($data));

            return back()->with('status', 'Please check your email.');
        } else return back()->withErrors('You have entered the wrong email address.');


        dd($request->request);
    }

    public function edit(string $menu)
    {
        $token = $this->getCookie('external_user');
        $ticket = $this->returnTicket($token);
        $student = Student::where('email', $ticket->request_email)->firstOrFail();

        $information_auth = false;
        $document_auth = false;
        $project_auth = false;
        $research_auth = false;

        if ($menu == 'information') $information_auth = true;
        else if ($menu == 'documents') $document_auth = true;
        else if ($menu == 'projects') $project_auth = true;
        else if ($menu == 'researches') $research_auth = true;
        else if ($menu != 'my-profile') abort(404);

        return view('dmiesys.external_users.student-profile-edit', compact('token', 'student', 'information_auth', 'document_auth', 'project_auth', 'research_auth'));
    }

    public function login($token)
    {
        $ticket = $this->returnTicket($token);

        $session = $this->getCookie('external_user');
        if (is_null($session)) {
            $time_left = 3600 * 3 - (strtotime(now()) - strtotime($ticket->created_at));
            $response = $this->setCookie('external_user', $token, $time_left);
            sleep(2);
            abort_unless($response, 500);
        }
        return redirect()->route('student-profile.edit', 'my-profile');
    }

    public function returnTicket($token)
    {
        $ticket = ExternalUserAccessToken::where('validity', 1)
            ->where('token', $token)
            ->where('created_at', '>=', now()->subHours(3))
            ->firstOrFail();
        return $ticket;
    }
}
