<?php

namespace App\Jobs\NewOrder;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNewOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Order $order
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $adminUsers = User::where('is_admin', true)->get();

        foreach ([...$adminUsers, $this->order->user] as $user) {
            dispatch(new SendNewOrderJob($this->order, $user));
        }
    }
}
