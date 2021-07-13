<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;
class Notification extends Controller
{
    //
    public function notify()
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data['message'] = 'My name is mujtaba';
        $pusher->trigger('deraya', 'App\\Events\\Notify', $data);

    }
    public function sendmsg(Request $req){
        $message=$req->input('message');
        

         $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data['message'] = $message;
        $pusher->trigger('deraya', 'App\\Events\\Notify', $data);
    }
    public function followed(){

    }
}
