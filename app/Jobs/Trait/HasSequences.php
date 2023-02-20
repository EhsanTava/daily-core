<?php

namespace App\Jobs\Trait;

use App\Models\Order;
use App\Models\OrderCoupon;
use App\Models\OrderLog;
use App\Models\OrderProduct;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

trait HasSequences
{
    protected function processTheNewOrder(array $newOrderParameters): void
    {
        $this->makeDocumentForNewOrder($newOrderParameters);

        $this->runSequences($newOrderParameters);
    }

    protected function makeDocumentForNewOrder(array $newOrderParameters): void
    {
        $this->makeDocumentInDatabase($newOrderParameters);

        $this->makeDocumentInFile($newOrderParameters);
    }

    protected function runSequences(array $newOrderParameters): void
    {
        $this->acknowledgeTheOrder($newOrderParameters);

        $this->packTheOrder($newOrderParameters);

        $this->acceptTheOrder($newOrderParameters);
    }

    protected function makeDocumentInDatabase(array $newOrderParameters): void
    {
        $separatedParameters = $this->parseParameters($newOrderParameters);

        $this->makeDocumentBySeparatedParameters($separatedParameters);
    }

    protected function parseParameters(array $parameters): array
    {
        return [
            'orderCoupon' => Arr::pull($parameters, 'orderCoupon'),
            'orderProducts' => Arr::pull($parameters, 'products'),
            'orderData' => $parameters,
        ];
    }

    protected function makeDocumentBySeparatedParameters(array $separatedParameters): void
    {
        /** @var Order $order */
        $order = Order::query()
            ->create($separatedParameters['orderData']);

        if (!empty($separatedParameters['orderCoupon'])) {
            $this->makeOrderCouponInDatabase($separatedParameters['orderCoupon'], $order->id);
        }

        $this->makeOrderProductInDatabase($separatedParameters['orderProducts'], $order->id);
    }

    protected function makeOrderCouponInDatabase(array $couponData, int $orderId): void
    {
        $preparedCoupon = $this->prepareCouponToInsert($couponData, $orderId);

        $preparedCoupon['rewardParams'] = 'sth';

        OrderCoupon::query()
            ->create($preparedCoupon);
    }

    protected function prepareCouponToInsert(array $couponData, int $orderId): array
    {
        $couponData['couponId'] = $couponData['id'];
        $couponData['orderId'] = $orderId;
        unset($couponData['id']);

        return $couponData;
    }

    protected function makeOrderProductInDatabase(array $products, int $orderId): void
    {
        $preparedProducts = $this->prepareProductsToInsert($products, $orderId);

        OrderProduct::query()
            ->insert($preparedProducts);
    }

    protected function prepareProductsToInsert(array $products, int $orderId): array
    {
        $castedProducts = [];

        foreach ($products as $product) {
            $product['orderId'] = $orderId;

            $product['productId'] = $product['id'];

            $product['created_at'] = now();
            $product['updated_at'] = now();

            unset($product['id']);

            $castedProducts[] = $product;
        }

        return $castedProducts;
    }

    protected function makeDocumentInFile(array $newOrderParameters): void
    {
        Log::stack(['daily-api'])->info($newOrderParameters);
    }

    protected function acknowledgeTheOrder(array $newOrderParameters): void
    {
        $this->changeOrderStatusInOrdersTable($newOrderParameters['code'], 1);

        $this->logTheOrderInDatabase($newOrderParameters);
    }

    protected function packTheOrder(array $newOrderParameters): void
    {
        $this->changeOrderStatusInOrdersTable($newOrderParameters['code'], 2);

        $this->logTheOrderInDatabase($newOrderParameters);
    }

    protected function acceptTheOrder(array $newOrderParameters): void
    {
        dispatch(function () use ($newOrderParameters) {
            $this->changeOrderStatusInOrdersTable($newOrderParameters['code'], 3);

            $this->logTheOrderInDatabase($newOrderParameters);
        })->delay(10);
    }

    protected function changeOrderStatusInOrdersTable(string $orderCode, int $statusCode): void
    {
        // TODO : put logging for discrod if(!updated)
        Order::query()
            ->where('code', $orderCode)
            ->update(['statusCode' => $statusCode]);
    }

    protected function logTheOrderInDatabase(array $parameters): void
    {

    }
}
