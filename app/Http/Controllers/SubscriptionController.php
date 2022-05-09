<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest;

class SubscriptionController extends Controller
{
    public function __construct()
    {
    }

    public function newSubscription(SubscriptionRequest $request)
    {
        DB::beginTransaction();
        try {
            $subscription               = new Subscription();
            $subscription->f_user_id    = $request->f_user_id;
            $subscription->f_website_id = $request->f_website_id;
            $subscription->save();
            //check if user already subsc
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 1,'message' => $e->getMessage()], 200);
        }
        DB::commit();
        return response()->json(['status' => 1,'message' => 'User subscribed successfully !'], 200);
    }
}
