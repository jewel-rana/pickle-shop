<?php

namespace App\Jobs;

use App\Events\OrderPlacedEvent;
use App\Mail\SendInvoiceMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class OrderInvoiceSendJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $order;
    private $user;

    public function __construct(OrderPlacedEvent $event)
    {
        $this->order = $event->order;
        $this->user = $event->user;
    }

    public function handle()
    {
        Mail::to($this->user)->send(new SendInvoiceMail($this->order));
    }
}
