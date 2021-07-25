<?php

namespace App\Notifications;

use App\Models\Configuracion;
use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Notifications\Messages\BroadcastMessage;

class WelcomeNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    var $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //por defecto las notificaciones se guardan en la base y se envian so
        $canales = ['database'];
        //si el sistema tiene activadas las notificaciones via email
        if (Configuracion::valor('notificaciones_mail') == '1')
            $canales[] = 'mail'; //agrego el canal email a los canales
        //si el sistema tiene activadas las notificaciones via websocket
        if (Configuracion::valor('notificaciones_websocket') == '1')
            $canales[] = 'broadcast'; //agrego el canal email a los canales
        //TODO:implementar campo configurable en perfil de usuario para gestionar notificaciones
        return $canales;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $app_name = Configuracion::valor('company_shortname');

        return (new MailMessage)
            ->subject('Bienvenido a ' . $app_name)
            ->markdown(
                'mail.welcome',
                ['user' => $notifiable]
            );
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
            'type'  => 'user_create',
            'resume' => "Nueva cuenta registrada para {$notifiable->name}",
            'user' => $notifiable
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type'  => 'user_create',
            'resume' => "Nueva cuenta registrada para {$notifiable->name}",
            'data' => $notifiable
        ]);
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\PrivateChannel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('users.' . $this->user->id);
    }
}