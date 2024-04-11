<?php

namespace App\Listeners;

use App\Events\RegisterEvent;
use App\Mail\UserMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class RegisterEventListener
{
    /**
     * Create the event listener.
     */

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RegisterEvent $event): void
    {
        //
        $email = $event->user->email;
        // dd($email);
        $message = [
            'Subject' => 'Registeration Successfull',
            'Body' => 'your account has been created successfully',
            'User' => $event->user->name,
        ];
        Mail::to($email)->send(new UserMail($message));
    }
}
