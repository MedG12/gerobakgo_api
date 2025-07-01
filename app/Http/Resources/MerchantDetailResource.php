<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'merchant_id' => $this->merchant_id,
            'name' => $this->user->name,
            'photoUrl' => $this->user->photoUrl,
            'description' => $this->description,
            'openHour' => $this->openHour,
            'closeHour' => $this->closeHour,
            'menus' => MenuResource::collection($this->whenLoaded('menus')),
        ];
    }
}
