<?php

namespace App\Jobs;

use App\DataTransferObjects\UpdateAppointmentJobDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Lib\Http\Request as CustomRequest;
class UpdateBookingAppointmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly UpdateAppointmentJobDTO $appointment)
    {
    }

    public function handle(): void
    {
        $response = CustomRequest::put([],[
            'status' => $this->appointment->status,
            'payment_status' => $this->appointment->payment_status
        ],'booking',"/reserves/".$this->appointment->id . "/update-status");
        try {
            \Log::debug($response->body()." => ".$response->status());
        }catch (\Exception $exception)
        {
            \Log::debug($response);
        }
        $response->body();
    }
}
