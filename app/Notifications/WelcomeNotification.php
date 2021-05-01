<?php

namespace App\Notifications;

use App\Models\Configuracion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //por defecto las notificaciones se guardan en la base
       $canales = ['database'];
       //si el usuario tiene activadas las notificaciones via email
       //TODO:implementar campo configurable en perfil de usuario para gestionar notificaciones
       //if(Utiles::getSetting('notificaciones_mail') == '1')
       //$canales[] = 'mail'; //agrego el canal email a los canales
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
        ->subject('Bienvenido a '.$app_name)
        ->markdown('mail.welcome',
            ['user'=>$notifiable]
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
            'resume' => "Nueva cuenta registrada para {$notifiable->name }",
            'user' => $notifiable
        ];
    }
}
