<?php

namespace App\Processors\Notifier;

use App\Models\Order;

class Notifier
{
    public function notifyReceivedSequences(array $newOrderData): void
    {
        $this->acknowledgeTheOrder($newOrderData);

        $this->packTheOrder($newOrderData);

        $this->acceptTheOrder($newOrderData);
    }

    protected function acknowledgeTheOrder(array $newOrderData): void
    {
        $this->changeOrderStatusInOrdersTable($newOrderData['code'], 1);

        $this->logDataWhichSentToContractParty($newOrderData);
    }

    protected function packTheOrder(array $newOrderData): void
    {
        $this->changeOrderStatusInOrdersTable($newOrderData['code'], 2);

        $this->logDataWhichSentToContractParty($newOrderData);
    }

    protected function acceptTheOrder(array $newOrderData): void
    {
        $this->changeOrderStatusInOrdersTable($newOrderData['code'], 3);

        $this->logDataWhichSentToContractParty($newOrderData);
    }

    protected function changeOrderStatusInOrdersTable(string $orderCode, int $statusCode): void
    {
        // TODO : put logging for discrod if(!updated)
        Order::query()
            ->where('code', $orderCode)
            ->update(['statusCode' => $statusCode]);
    }

    protected function logDataWhichSentToContractParty(array $parameters): void
    {

    }
}
