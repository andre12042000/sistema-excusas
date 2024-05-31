<?php

namespace App\Notifications;

use App\Models\Excusas;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ExcusaRechazadoNotificacion extends Notification
{
    use Queueable;
    public $excusa;
    /**
     * Create a new notification instance.
     */
    public function __construct(Excusas $excusas)
    {
        $this->excusa = $excusas;
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [

            'message' => 'Tu excusa fue a rechazada',
            'alumno' => $this->excusa->estudiante->name,
            'grado' => $this->excusa->grado,
            'fecha' => $this->excusa->created_at,
            'observaciones' => $this->excusa->observaciones,

        ];
    }
}
