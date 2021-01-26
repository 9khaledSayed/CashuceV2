<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index()
    {
        $allNotifications = auth()->user()->notifications;
        $readNotifications = auth()->user()->readNotifications;
        $unReadNotifications = auth()->user()->unReadNotifications;
        return view('dashboard.notifications.index', compact([
            'allNotifications',
            'unReadNotifications',
            'readNotifications'
        ]));
    }

    public function markAsRead($notificationID)
    {
        $notification = auth()->user()->notifications->where('id', $notificationID)->first();
        $notification->markAsRead();
        return redirect($notification->data['redirectURL']);

    }

    public function unReadNotificationsNumber()
    {
        $unReadNotificationsNumber = auth()->user()->unReadNotifications->count();
        return response()->json([
           'unReadNotificationsNumber' => $unReadNotificationsNumber
        ]);
    }
}
