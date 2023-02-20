<?php

namespace App\Jobs;

use App\Jobs\Trait\HasSequences;
use App\Models\User;
use App\Processors\OrderProcessorInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use HasSequences;

    /**
     * Create a new job instance.
     */
    public function __construct(protected array $newOrderData)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(OrderProcessorInterface $orderProcessor): void
    {
        $orderProcessor->process($this->newOrderData);
    }
}
