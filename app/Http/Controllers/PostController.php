<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Post;
use App\Models\Subscription;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function __construct(){

    }

    public function newPost(PostRequest $request)
    {
        DB::beginTransaction();
        try {
            $post = new Post();
            $post->title        = $request->title;
            $post->description  = $request->description;
            $post->f_website_id = $request->f_website_id;
            $post->save();

            $all_users = Subscription::select('name','email')->join('users','users.id','subscriptions.f_user_id')->where('f_website_id',$request->f_website_id)->get()->toArray();

            // send all mail in the queue.
            $details = [
                'subject'       => 'New Post Notification',
                'title'         => $request->title,
                'description'   => $request->description,
            ];
            $job = (new \App\Jobs\SendBulkQueueEmail($details,$all_users))
                ->delay(
                    now()
                    ->addSeconds(2)
                );
            dispatch($job);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 1,'message' => $e->getMessage()], 200);
        }
        DB::commit();
        return response()->json(['status' => 1,'message' => 'Post addded successfully !'], 200);
    }
}
