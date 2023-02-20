<?php

namespace App\Processors;

interface OrderProcessorInterface
{
    public function process(array $newOrderParameters): void;
}
