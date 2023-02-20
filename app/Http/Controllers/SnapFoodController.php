<?php

namespace App\Http\Controllers;

use App\Http\Requests\newOrderRequest;
use App\Models\User;
use App\Repositories\Contracts\SnapFoodServiceInterface;
use Illuminate\Http\Request;
use SzkCompany\Responser\Responser;

class SnapFoodController extends Controller
{
    public function __construct(protected SnapFoodServiceInterface $snapFoodService)
    {
    }

    public function newOrder(int $storeId, Request $request)
    {
        $this->snapFoodService->processNewOrder(
            array_merge($request->all(), [
                'storeId' => $storeId,
                'channel_id' => 1 // TODO : make numbers for this channels // write this in request validation
                ])
        );

        Responser::success(true);
    }
}
