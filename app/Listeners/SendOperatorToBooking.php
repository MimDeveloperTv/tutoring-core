<?php

namespace App\Listeners;

use App\Events\OperatorCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class SendOperatorToBooking
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
    public function handle(OperatorCreatedEvent $event): void
    {
        Http::withHeaders([
             'api_key' => config('microservices.services.core_clinic.api_key'),
             'Accept' => 'application/json',
             'Content-Type' => 'application/json'
        ])->get(config('services.booking.base_url')."/operators/$event->user_id/services",[]);
    }

}
