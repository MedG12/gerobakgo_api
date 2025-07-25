<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MerchantDetailCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($merchant) {
                return [
                    'merchant_id' => $merchant->merchant_id,
                    'name' => $merchant->user->name,
                    'photoUrl' => $merchant->user->photoUrl,
                    'description' => $merchant->description,
                    'openHour' => Carbon::parse($merchant->openHour)->format('H:i'),
                    'closeHour' => Carbon::parse($merchant->closeHour)->format('H:i'),
                    'location' => $merchant->location
                ];
            }),
            'meta' => [
                'count' => $this->collection->count(),
            ],
        ];
    }
}
