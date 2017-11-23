<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class Signin extends Notification {

  public function __construct($user) {
     $this->user = $user;
  }

  public function via($notifiable) {
    return ['mail'];
  }

  public function toMail($notifiable){
    $mail = (new MailMessage)
       ->subject('Nouvelle adhésion')
       ->greeting('Quelqu\'un désire adhérer à la SMAG.');

    $mail->line('Nom: ' . $this->user->name());
    $mail->line('Email: ' . $this->user->email);
    $mail->line('Téléphone: ' . $this->user->phone);
    $mail->line('Téléphone professionel: ' . $this->user->phonepro);
    $mail->line('Mobile: ' . $this->user->mobile);
    $mail->line('Adresse privée: ' . $this->user->adress . " " . $this->user->adress_zip . " " . $this->user->adress_city . " " . $this->user->adress_country);
    $mail->line('Adresse privée: ' . $this->user->adresspro . " " . $this->user->adresspro_zip . " " . $this->user->adresspro_city . " " . $this->user->adresspro_country);
    $mail->line('Parrains: ' . $this->user->sponsor1 . ", ", $this->user->sponsor2);

    $mail->action('Connectez-vous pour valider l\'inscription.', url('/login'));

    return $mail;
  }

  // public function toArray($notifiable) {
  //     return [
  //         'message' => 'A new post was published on Laravel News.',
  //         'action' => url($this->post->slug)
  //     ];
  // }
}
