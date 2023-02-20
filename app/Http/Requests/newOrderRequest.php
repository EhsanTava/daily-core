<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class newOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'unique:orders,code'],
            'price' => ['required', 'integer'],
            'orderDate' => ['required', 'integer'],
            'userCode' => ['required', 'string'],
            'userAddressCode' => ['required', 'string'],
            'statusCode' => ['required', 'integer', 'exists:statuses,id'],
            'fullName' => ['required', 'string'],
            'firstName' => ['required', 'string'],
            'lastName' => ['required', 'string'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-90,90'],
            'deliverAddress' => ['required', 'between:-90,90'],
            'comment' => ['string'],
            'phone' => ['required', 'string'],
            'tax' => ['required', 'integer'],
            'deliveryPrice' => ['required', 'integer'],
            'packingPrice' => ['required', 'integer'],
            'deliveryTime' => ['required', 'integer'],
            'preparationTime' => ['required', 'integer'],
            'taxCoeff' => ['required', 'integer'],
            'vat' => ['required', 'string'],
            'discountType' => ['string'],
            'discountValue' => ['required', 'integer'],
            'newOrderDate' => ['date'],
            'orderPaymentTypeCode' => ['required', 'string'],
            'vendorCode' => ['required', 'string'],
            'channel_id' => ['integer', 'exists:channels,id'],

            'orderCoupon' => ['array'],
            'orderCoupon.*.id' => ['required', 'integer'],
            'orderCoupon.*.title' => ['required', 'string'],
            'orderCoupon.*.descriptions' => ['required', 'string'],
            'orderCoupon.*.conditionCode' => ['required', 'string'],
            'orderCoupon.*.rewardCode' => ['required', 'string'],
            'orderCoupon.*.rewardParams' => ['required', 'array'],
            'orderCoupon.*.rewardParams.*.item' => ['required', 'string'],
            'orderCoupon.*.rewardParams.*.VmsFoodId' => ['required', 'integer'],

            'products' => ['required', 'array'],
            'products.*.id' => ['required', 'integer'],
            'products.*.quantity' => ['required', 'integer'],
            'products.*.price' => ['required', 'integer'],
            'products.*.title' => ['required', 'string'],
            'products.*.discount' => ['required', 'integer'],
            'products.*.vat' => ['required', 'numeric'],
            'products.*.barcode' => ['required', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'channel_id' => empty($this->channel_id) ? 1 : $this->channel_id, // 1 => means channel
        ]);
    }
}
