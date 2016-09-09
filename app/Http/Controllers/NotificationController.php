<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notification = auth()->user()->notifications;
        auth()->user()->unreadNotifications()->update(['read_at' => Carbon::now()]);
        return response()->json(['notification' => $notification]);
    }

    /**
     * Get the count of unread notification
     *
     * @return \Illuminate\Http\Response
     */
    public function notification_count()
    {
        $unread_notification_count = auth()->user()->unreadNotifications->count();
        return response()->json(['notification_count' => $unread_notification_count]);
    }
}
