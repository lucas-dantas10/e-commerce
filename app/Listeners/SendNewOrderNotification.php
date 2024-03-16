<?php

namespace App\Listeners;

use App\Events\NewOrderCreatedEvent;
use App\Jobs\NewOrder\SendNewOrdersJob;

class SendNewOrderNotification
{
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(NewOrderCreatedEvent $event): void
    {
        dispatch(new SendNewOrdersJob($event->order));
    }
}
