<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'menu_id' => $this->menu_id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'photoUrl' => $this->photoUrl,
        ];
    }
}
