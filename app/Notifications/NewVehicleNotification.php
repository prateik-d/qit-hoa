<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewVehicleNotification extends Notification
{
    use Queueable;

    protected $vehicle;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($vehicle)
    {
        $this->vehicle = $vehicle;
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
            'vehicle_id' => $this->vehicle->id,
            'owner_id' => $this->vehicle->owner_id,
            'owned_by' => $this->vehicle->owned_by,
            'vehicle_make_id' => $this->vehicle->vehicle_make_id,
            'vehicle_model_id'  => $this->vehicle->vehicle_model_id,
            'vehicle_color_id'  => $this->vehicle->vehicle_color_id,
            'license_plate_no'  => $this->vehicle->license_plate_no,
            'toll_tag_no'  => $this->vehicle->toll_tag_no,
            'access_toll_tags_needed'  => $this->vehicle->access_toll_tags_needed,
            'stickers_needed'  => $this->vehicle->stickers_needed,
            'application_date'  => $this->vehicle->application_date
        ];
    }
}
