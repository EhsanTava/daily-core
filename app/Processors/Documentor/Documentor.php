<?php

namespace App\Processors\Documentor;

use App\Models\Order;
use App\Models\OrderCoupon;
use App\Models\OrderProduct;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class Documentor
{
    public function makeNewOrder(array $newOrderData): void
    {
        $this->inDatabase($newOrderData);

        $this->inFile($newOrderData);
    }

    protected function inDatabase(array $newOrderData): void
    {
        $separatedParameters = $this->parseParameters($newOrderData);

        $this->inDatabaseBySeparatedParams($separatedParameters);
    }

    protected function inFile(array $newOrderData): void
    {
        Log::stack(['daily-api'])->info($newOrderData);
    }

    protected function parseParameters(array $parameters): array
    {
        return [
            'orderCoupon' => Arr::pull($parameters, 'orderCoupon'),
            'orderProducts' => Arr::pull($parameters, 'products'),
            'orderData' => $parameters,
        ];
    }

    protected function inDatabaseBySeparatedParams(array $newOrderData): void
    {
        $order = Order::query()
            ->create($newOrderData['orderData']);

        if (!empty($separatedParameters['orderCoupon'])) {
            $this->orderCouponDatabase($newOrderData['orderCoupon'], $order->id);
        }

        $this->orderProductInDatabase($newOrderData['orderProducts'], $order->id);
    }

    protected function orderCouponDatabase(array $couponData, int $orderId): void
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

    protected function orderProductInDatabase(array $products, int $orderId): void
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
}
