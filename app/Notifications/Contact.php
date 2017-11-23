<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class Contact extends Notification {

  public function __construct($inputs) {
     $this->inputs = $inputs;
  }

  public function via($notifiable) {
    return ['mail'];
  }

  public function toMail($notifiable){
    $mail = (new MailMessage)
       ->subject($this->inputs['_subject'])
       ->greeting($this->inputs['_subject']);

    foreach ($this->inputs as $k => $v) {
      if ($k == "from") {
        $mail->from($this->inputs['from'])->line('Mail: ' . $v);
      } else if (substr($k, 0, 1) !== "_") {
        $mail->line(ucwords(str_replace("_", " ", $k)) . ": " . nl2br($v));
      }
    }

    return $mail;
  }
}
