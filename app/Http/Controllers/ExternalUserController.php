<?php

namespace App\Http\Controllers;

use App\Mail\RequestExternalUserAccessToken;
use App\Models\ExternalUserAccessToken;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ExternalUserController
{
    public function index()
    {
        return view('auth.external-user-login');
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'category' => 'required|in:undergraduate,alumni|',
            'batch' => 'required_if:category,undergraduate|starts_with:E|max:3|alpha_num',
            'student_id' => 'required_if:category,undergraduate|starts_with:E|max:6|alpha_num',
            'email' => 'required|email'
        ])->validate();

        $old_access_token = ExternalUserAccessToken::where('validity', 1)
            ->where('request_email', $request->email)
            ->where('created_at', '>=', now()->subHours(6))->first();

        if (!is_null($old_access_token)) return back()->withErrors('Please wait before submitting another request.');

        if ($request->category == 'undergraduate') {
            $student = Student::where('student_id', $request->student_id)->first();
            if ($student->email == $request->email) {

                $access_token = hash('sha512', Str::random(50));

                $token = new ExternalUserAccessToken();
                $token->category = $request->category;
                $token->from_table = $request->category;
                $token->request_email = $request->email;
                $token->token = $access_token;
                $token->save();

                $data = [
                    'url' => config('app.url') . '/external-user/' . $access_token . '/edit',
                ];

                Mail::to($request->email)->send(new RequestExternalUserAccessToken($data));

                return back()->with('status', 'Please check your email.');
            } else return back()->withErrors('You have entered the wrong email address.');
        }

        dd($request->request);
    }

    public function show(ExternalUserAccessToken $externalUser)
    {
    }

    public function edit(string $token)
    {
        dd($token);
    }

    public function update(Request $request, ExternalUserAccessToken $externalUser)
    {
    }

    public function destroy(ExternalUserAccessToken $externalUser)
    {
    }
}
