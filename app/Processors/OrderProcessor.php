<?php

namespace App\Processors;

use App\Processors\Documentor\Documentor;
use App\Processors\Notifier\Notifier;

class OrderProcessor implements OrderProcessorInterface
{
    public function __construct(
        protected Documentor $documentor,
        protected Notifier $notifier,
    )
    {
    }

    public function process(array $newOrderParameters): void
    {
        $this->documentor->makeNewOrder($newOrderParameters);

        $this->notifier->notifyReceivedSequences($newOrderParameters);
    }
}
