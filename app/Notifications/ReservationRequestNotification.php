<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationRequestNotification extends Notification
{
    use Queueable;

    protected $reservation;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
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
            'reservation_id' => $this->reservation->id,
            'amenity_id' => $this->reservation->amenity_id,
            'purpose' => $this->reservation->purpose,
            'description' => $this->reservation->description,
            'booked_by' => $this->reservation->booked_by,
            'booking_date' => $this->reservation->booking_date,
            'timeslots_start' => $this->reservation->timeslots_start,
            'timeslots_end' => $this->reservation->timeslots_end,
            'booking_price' => $this->reservation->booking_price,
            'payment_mode' => $this->reservation->payment_mode,
            'payment_date' => $this->reservation->payment_date,
            'payment_status' => $this->reservation->payment_status,
        ];
    }
}
