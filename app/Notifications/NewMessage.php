<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessage extends Notification
{
    use Queueable;

    private $conversationID;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($conversationID)
    {
        $this->conversationID = $conversationID;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('You Have new message.')
                    ->action('Open Conversation', route('dashboard.conversations.show', $this->conversationID))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'redirectURL' => route('dashboard.conversations.show', $this->conversationID),
            'message' => 'You have new message',
            'date' => Carbon::today()->format('Y-m-d'),
        ];
    }
}
