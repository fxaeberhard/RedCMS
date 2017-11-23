<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\User;
// use Mail;
use App\Notifications\Contact;

class FormController extends BlockController {

  public function sendMail(Request $request) {

    $inputs = $request->all();

    Notification::send(User::administrators(), new Contact($inputs));

    // Mail::send('blocks.form-mail', ['inputs' => $inputs], function ($m) use ($request) {
    //     $m->from(env('MAIL_FROM_ADDRESS', 'webmaster@red-agent.com'))
    //       ->to($request->input('_target'))
    //       ->subject($request->input('_subject'));
    // });
  }
}
