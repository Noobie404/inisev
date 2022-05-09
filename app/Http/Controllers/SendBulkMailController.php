<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SendBulkMailController extends Controller
{
    public function sendBulkMail(Request $request)
    {
        $details = [
            'subject' => 'Weekly Notification',
            'title' => 'asdfsdf',
            'description' => 'dedededed'
        ];
        // send all mail in the queue.
        $job = (new \App\Jobs\SendBulkQueueEmail($details,array(array('name' => 'sifat','email' => 'syedsifat02@gmail.com'))))
            ->delay(
                now()
                ->addSeconds(2)
            );
        dispatch($job);
        echo "Bulk mail send successfully in the background...";
    }
}
