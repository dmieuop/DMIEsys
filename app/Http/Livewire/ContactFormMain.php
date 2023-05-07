<?php

namespace App\Http\Livewire;

use App\Mail\ContactFormMail;
use App\Models\ContactFormMessage;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactFormMain extends Component
{
    /** @var string */
    public $name;
    /** @var string */
    public $email;
    /** @var string */
    public $phone;
    /** @var string */
    public $message;
    /** @var bool */
    public $is_success;
    /** @var bool */
    public $is_failed;
    /** @var string */
    public $errormsg;

    /**
     * @return void
     */
    public function boot()
    {
        $this->is_success = false;
        $this->is_failed = false;
        $this->errormsg = 'Error';
    }

    /**
     * @return array
     */
    protected function rules()
    {
        return [
            'name' => 'bail|required|max:50',
            'email' => 'bail|required|email|max:100',
            'phone' => 'bail|required|max:15|alpha_num',
            'message' => 'bail|required|string',
        ];
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.contact-form-main');
    }

    /**
     * @param string $ip
     * @return \Illuminate\Http\RedirectResponse
     */
    public function formSubmit(string $ip)
    {
        try {
            $this->validate();
        } catch (\Throwable $th) {
            $this->is_failed = true;
            $this->errormsg = 'Check fields again!';
            return back();
        }

        //check daily message limit
        $old_messages_count = ContactFormMessage::where('ip', $ip)->where('created_at', '>', now()->subDay())->count();

        if ($old_messages_count >= 3) {
            $this->is_failed = true;
            $this->errormsg = 'Daily limit reached!';
            return back();
        }

        try {
            ContactFormMessage::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'message' => $this->message,
                'ip' => $ip
            ]);
        } catch (\Throwable $th) {
            $this->is_failed = true;
            $this->errormsg = 'Something went wrong!';
            return back();
        }

        try {
            $body = [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'message' => $this->message
            ];
            Mail::to(env('MAIL_RECIPIENT'))->send(new ContactFormMail($body));
        } catch (\Throwable $th) {
            $this->is_failed = true;
            $this->errormsg = 'Something went wrong!';
            return back();
        }

        $this->is_success = true;
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->message = '';
        return back();
    }
}
