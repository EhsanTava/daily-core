<?php

namespace App\Repositories\Contracts;

interface SnapFoodServiceInterface
{
    public function processNewOrder(array $parameters): bool;
}
