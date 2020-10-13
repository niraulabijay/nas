<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(10);

        $data = [
            'notifications' => $notifications,
        ];  

        return response()->json($data, Response::HTTP_OK);
    }

    public function notificationsCount()
    {
        $count = auth()->user()->unreadNotifications->count();
        return response()->json(['count' => $count], Response::HTTP_OK);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['msg' => 'All Notifications has been marked as read.'], Response::HTTP_OK);
    }

    public function markAsRead($id)
    {
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        return response()->json(['msg' => 'One Notification has been marked as read.'], Response::HTTP_OK);
    }
}
