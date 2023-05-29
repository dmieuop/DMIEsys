<?php

namespace App\Console\Commands;

use App\Mail\RemindToMeetStudent;
use App\Models\ExternalUserAccessToken;
use App\Models\Student;
use App\Models\User;
use App\Traits\Notify;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DeactivateOldAccessTable extends Command
{
    use Notify;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DeactivateOldAccessTable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will check and deactivate any old external user access tokens after 3 hrs they were created.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $tokens = ExternalUserAccessToken::where('validity', 1)->get();
        foreach ($tokens as $token) {
            if ($token->created_at < now()->subHours(3)) {
                $token->validity = 0;
                $token->save();
            }
        }
    }
}
