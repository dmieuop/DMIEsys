<?php

namespace App\Http\Controllers;

use App\Mail\NewPGRegistration;
use App\Mail\PGRegistrationReferee;
use App\Models\PGRCompany;
use App\Models\PGRMembership;
use App\Models\PGRReferee;
use App\Models\PGRUniversity;
use App\Models\PostgraduateRegistration;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PGRegController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $year = Setting::where('key', 'pg-intake-year')->value('value');
        $emgt = Setting::where('key', 'pg-emgt-offer')->value('bool');
        $meng = Setting::where('key', 'pg-meng-offer')->value('bool');
        $opendate = Setting::where('key', 'pg-application-open-date')->value('value');
        $closedate = Setting::where('key', 'pg-application-close-date')->value('value');

        return view('main.pg.register', compact('year', 'emgt', 'meng', 'opendate', 'closedate'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function store(Request $request)
    {

        $random_phase = Str::of(Str::random(50))->pipe('md5');
        $year = Setting::where('key', 'pg-intake-year')->value('value');

        Validator::make(
            $request->all(),
            [
                'ip' => 'present|ip|unique:postgraduate_registrations',
            ],
            $messages = [
                'ip.present' => 'Something is wrong. Please try again.',
                'ip.ip' => 'Something is wrong. Please try again.',
                'ip.unique' => 'You just submitted an application. You can not submit again.'
            ]
        )->validate();

        Validator::make(
            $request->all(),
            [
                'applied_degree' => 'required|string|max:100',
                'degree_cat' => 'required|string|max:50',
                'fname' => 'required|alpha|max:50',
                'lname' => 'required|alpha|max:50',
                'fullname' => 'required|string|max:100',
                'nic' => 'required|unique:postgraduate_registrations|alpha_num|max:15',
                'email' => 'required|email|unique:postgraduate_registrations|max:50',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'gender' => 'required|in:male,female,notsay',
                'birthday' => 'required|date|before:today',
                'employment' => 'required|in:employed,unemployed',
                'degreecetificate1' => 'required|mimes:pdf|max:20480',
                'file_nic' => 'required|mimes:pdf|max:20480',
                'inductryexp' => 'nullable|mimes:pdf|max:20480',
                'transcript' => 'required|mimes:pdf|max:20480',
                'ugcapproval' => 'nullable|mimes:pdf|max:20480',
                'bank_slip' => 'nullable|mimes:pdf|max:20480',
                'r1name' => 'required|string|max:100',
                'r1email' => 'required|email|max:50',
                'r1designation' => 'required|string',
                'r2name' => 'required|string|max:100',
                'r2email' => 'required|email|max:50',
                'r2designation' => 'required|string',
            ],
        )->validate();

        for ($i = 1; $i <= $request['noofuniversities']; $i++) {
            try {
                $request->validate([
                    'degreetype' . $i => 'required|string|max:30',
                    'university' . $i => 'required|string|max:100',
                    'year' . $i => 'required|string|max:4',
                    'specialization' . $i => 'nullable|string|max:100',
                    'class' . $i => 'nullable|string|max:15',
                    'credits' . $i => 'nullable|between:0,150',
                    'gpa' . $i => 'nullable|string|max:4',
                    'degreecetificate' . $i => 'nullable|mimes:pdf|max:20480',
                ]);
            } catch (\Throwable $th) {
                return back()->withErrors('Educational Qualifications section not complete!')->withInput();
            }
        }

        for ($i = 1; $i <= $request['noofcompanies']; $i++) {
            try {
                $request->validate([
                    'position' . $i => 'required|string|max:50',
                    'employer' . $i => 'required|string|max:100',
                    'period' . $i => 'required|string|max:20',
                ]);
            } catch (\Throwable $th) {
                return back()->withErrors('Employment History section not complete!')->withInput();
            }
        }

        for ($i = 1; $i <= $request['noofmemberships']; $i++) {
            try {
                $request->validate([
                    'organization' . $i => 'required|string|max:100',
                    'membershipcat' . $i => 'required|string|max:100',
                    'membershipno' . $i => 'required|string|max:20',
                    'file_membership' . $i => 'nullable|mimes:pdf|max:20480',
                ]);
            } catch (\Throwable $th) {
                return back()->withErrors('Professional Qualifications section not complete!')->withInput();
            }
        }

        DB::beginTransaction();

        try {
            PostgraduateRegistration::create([
                'applied_degree' => $request['applied_degree'],
                'degree_cat' => $request['degree_cat'],
                'fname' => $request['fname'],
                'lname' => $request['lname'],
                'fullname' => $request['fullname'],
                'nic' => Str::upper($request['nic']),
                'email' => Str::lower($request['email']),
                'phone' => $request['phone'],
                'address' => $request['address'],
                'gender' => $request['gender'],
                'birthday' => $request['birthday'],
                'employment' => $request['employment'],
                'year' => $year,
                'noofuniversities' => $request['noofuniversities'],
                'noofcompanies' => $request['noofcompanies'],
                'noofmemberships' => $request['noofmemberships'],
                'file_path' => 'pg-registration/' . $year . '/' . $random_phase . '/',
                'random_phase' => $random_phase,
                'ip' => $request['ip'],
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors('System failed when inserting personal details.')->withInput();
        }

        try {
            for ($i = 1; $i <= $request['noofuniversities']; $i++) {
                PGRUniversity::create([
                    'nic' => Str::upper($request['nic']),
                    'degreetype' => $request['degreetype' . $i],
                    'university' => $request['university' . $i],
                    'year' => $request['year' . $i],
                    'specialization' => $request['specialization' . $i],
                    'class' => $request['class' . $i],
                    'credits' => $request['credits' . $i],
                    'gpa' => $request['gpa' . $i],
                    'hascetificate' => $request->hasFile('degreecetificate' . $i),
                    'registration_year' => $year,
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors('System failed when inserting education qulification data.')->withInput();
        }

        try {
            for ($i = 1; $i <= $request['noofcompanies']; $i++) {
                PGRCompany::create([
                    'nic' => Str::upper($request['nic']),
                    'position' => $request['position' . $i],
                    'employer' => $request['employer' . $i],
                    'period' => $request['period' . $i],
                    'registration_year' => $year,
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors('System failed when inserting employement history data.')->withInput();
        }

        try {
            for ($i = 1; $i <= $request['noofmemberships']; $i++) {
                PGRMembership::create([
                    'nic' => Str::upper($request['nic']),
                    'organization' => $request['organization' . $i],
                    'membershipcat' => $request['membershipcat' . $i],
                    'membershipno' => $request['membershipno' . $i],
                    'hasproof' => $request->hasFile('file_membership' . $i),
                    'registration_year' => $year,
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors('System failed when inserting professional qualification data.')->withInput();
        }

        $tokens = [
            hash('sha384', Str::random(50)),
            hash('sha384', Str::random(50))
        ];

        try {
            for ($i = 1; $i <= 2; $i++) {
                PGRReferee::create([
                    'place' => $i,
                    'nic' => Str::upper($request['nic']),
                    'name' => $request['r' . $i . 'name'],
                    'email' => $request['r' . $i . 'email'],
                    'designation' => $request['r' . $i . 'designation'],
                    'token' => $tokens[$i - 1],
                    'exp_date' => now()->addWeeks(2),
                    'registration_year' => $year,
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors('System failed when inserting referee data')->withInput();
        }

        try {
            $destination_path = 'pg-registration/' . $year . '/' . $random_phase;
            $file_nic = 'nic_copy.pdf';
            $transcript = 'transcript.pdf';
            $bank_slip = 'bank_slip.pdf';
            $request->file('file_nic')->storeAs($destination_path, $file_nic);
            $request->file('bank_slip')->storeAs($destination_path, $bank_slip);
            $request->file('transcript')->storeAs($destination_path, $transcript);
            if ($request->hasFile('ugcapproval')) {
                $ugcapproval = 'ugc_approval.pdf';
                $request->file('ugcapproval')->storeAs($destination_path, $ugcapproval);
            }
            if ($request->hasFile('inductryexp')) {
                $inductryexp = 'evidence_of_industrial_experience.pdf';
                $request->file('inductryexp')->storeAs($destination_path, $inductryexp);
            }
            for ($i = 1; $i <= $request['noofuniversities']; $i++) {
                if ($request->hasFile('degreecetificate' . $i)) {
                    $degreecetificate = $i . '_degree_certificate.pdf';
                    $request->file('degreecetificate' . $i)->storeAs($destination_path, $degreecetificate);
                }
            }
            if ($request['noofmemberships'] != 0) {
                for ($i = 1; $i <= $request['noofmemberships']; $i++) {
                    $file_membership = $i . '_membership_proof_document.pdf';
                    $request->file('file_membership' . $i)->storeAs($destination_path, $file_membership);
                }
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors('System failed when uploading files.')->withInput();
        }

        try {
            $body = [
                'name' => $request['fname'] . ' ' . $request['lname'],
                'year' => $year,
            ];
            Mail::to($request['email'])->send(new NewPGRegistration($body));

            $gender = '';
            if ($request['gender'] == 'male') $gender = 'his';
            else if ($request['gender'] == 'female') $gender = 'her';
            else if ($request['gender'] == 'notsay') $gender = 'his/her';
            for ($i = 1; $i <= 2; $i++) {
                $body = [
                    'applicantname' => $request['fname'] . ' ' . $request['lname'],
                    'gender' => $gender,
                    'degree' => $request['applied_degree'],
                    'cat' => $request['degree_cat'],
                    'refereename' => $request['r' . $i . 'name'],
                    'url' => config('app.url') .  '/pg-registration/referee-report-upload/' . $tokens[$i - 1],
                    'exp_date' => now()->addWeeks(2)->toDateString(),
                ];
                Mail::to($request['r' . $i . 'email'])->send(new PGRegistrationReferee($body));
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors('System failed when sending emails.');
        }


        return back()->with('toast_success', 'Your application was submitted successfully.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $token)
    {
        Validator::make(
            $request->all(),
            [
                'referee_report' => 'required|mimes:pdf|max:20480',
            ],
        )->validate();

        $referee = PGRReferee::where('token', $token)->firstOrFail();
        $student = PostgraduateRegistration::where('nic', $referee->nic)->firstOrFail();

        DB::beginTransaction();

        try {
            $referee->is_submit = 1;
            if ($referee->place == '1') $student->r1_is_submit = 1;
            elseif ($referee->place == '2') $student->r2_is_submit = 1;
            $referee->save();
            $student->save();
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors('System failed when uploading files.');
        }

        try {
            $destination_path = $student->file_path;
            $file_report = 'referee_report_' . $referee->place . '.pdf';
            $request->file('referee_report')->storeAs($destination_path, $file_report);
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors('System failed when uploading files.');
        }

        DB::commit();

        return back();
    }

    /**
     * @param string $token
     * @return \Illuminate\View\View
     */
    public function refereeReportUpload($token)
    {
        $referee = PGRReferee::where('token', $token)->firstOrFail();

        if ($referee->exp_date < now()) $link_expired = true;
        else $link_expired = false;

        $student = PostgraduateRegistration::where('nic', $referee->nic)->firstOrFail();

        return view('main.pg.upload-referee-report', compact('referee', 'link_expired', 'referee', 'student'));
    }
}
