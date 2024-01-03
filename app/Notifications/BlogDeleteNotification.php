<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BlogDeleteNotification extends Notification
{
    use Queueable;
    protected $blog;
    protected $blogData;
    /**
     * Create a new notification instance.
     *
     * @param array $userData The data to be stored for the user addition notification
     */
    public function __construct(object $blog)
    {
        $this->blog = $blog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'A blog ' . $this->blog->title . ' has been deleted at ' . now(),
        ];
    }
}
