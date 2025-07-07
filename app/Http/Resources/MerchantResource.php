<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'merchant_id' => $this->merchant_id,
            'name' => $this->user->name,
            'photoUrl' => $this->user->photoUrl,
            'description' => $this->description,
            'openHour' => Carbon::parse($this->openHour)->format('H:i'),
            'closeHour' => Carbon::parse($this->closeHour)->format('H:i'),
            'location' => $this->location
        ];
    }
}
