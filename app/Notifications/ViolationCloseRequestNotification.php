<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ViolationCloseRequestNotification extends Notification
{
    use Queueable;

    protected $violation;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($violation)
    {
        $this->violation = $violation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'violation_id' => $this->violation->id,
            'user_id' => $this->violation->user_id,
            'violation_type_id' => $this->violation->violation_type_id,
            'description' => $this->violation->description,
            'violation_date' => $this->violation->violation_date,
            'approved_by' => $this->violation->approved_by,
            'moderator_comment' => $this->violation->moderator_comment,
            'user_reply' => $this->violation->user_reply,
            'status' => $this->violation->status
        ];
    }
}
