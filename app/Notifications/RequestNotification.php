<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Auth;

class RequestNotification extends Notification
{
    use Queueable;
    public $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'sender_id'=>Auth::user()->id,
            'sender_name'=>Auth::user()->full_name,

            'type'=>$this->data['type'],  
            'request_id'=>$this->data['request_id'],  
            'description'=>$this->data['description'],
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'sender_id'=>Auth::user()->id,
            'sender_name'=>Auth::user()->full_name,
            
            'type'=>$this->data['type'],  
            'request_id'=>$this->data['request_id'],  
            'description'=>$this->data['description'],
        ]);
    }
}
