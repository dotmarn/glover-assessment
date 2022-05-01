<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\UserRequestEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\RequestEmailNotification;

class SendEmailNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserRequestEvent $event)
    {
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->whereNot('id', \request()->user()->id)->get();

        if ($admins) {
            foreach ($admins as $admin) {
                $admin->notify(new RequestEmailNotification());
            }
        }
    }
}
