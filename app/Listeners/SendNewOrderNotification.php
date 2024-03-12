<?php

namespace App\Listeners;

use App\Events\NewOrderCreatedEvent;
use App\Jobs\NewOrder\SendNewOrdersJob;
use App\Mail\NewOrderEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendNewOrderNotification
{
    public function __construct()
    {}

    /**
     * Handle the event.
     */
    public function handle(NewOrderCreatedEvent $event): void
    {
        dispatch(new SendNewOrdersJob($event->order));
    }
}
