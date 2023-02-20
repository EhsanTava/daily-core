<?php

namespace App\Repositories;

use App\Jobs\NewOrder;
use App\Models\User;
use App\Repositories\Contracts\SnapFoodServiceInterface;
use Illuminate\Support\Arr;

class SnapFoodServiceRepository implements SnapFoodServiceInterface
{

    public function processNewOrder(array $parameters): bool
    {
        NewOrder::dispatch($parameters);

        return true;
    }
}
