<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Mail;

class SendBulkQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_emails;
    protected $details;
    public $timeout = 7200; // 2 hours

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details,$user_emails)
    {
        $this->details      = $details;
        $this->user_emails  = $user_emails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $input['subject']       = $this->details['subject'];
        $input['title']         = $this->details['title'];
        $input['description']   = $this->details['description'];

        foreach ($this->user_emails as $key => $value) {
            // dd($value['email']);
            $input['email'] = $value['email'];
            $input['name'] = $value['name'];
            \Mail::send('Mail.mail', $input, function($message) use($input){
                $message->to($input['email'], $input['name'])
                    ->subject($input['subject']);
            });
        }
    }
}
