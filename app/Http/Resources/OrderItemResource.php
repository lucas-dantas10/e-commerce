<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           'id' => $this->id, 
           'date' => (new DateTime($this->created_at))->format('Y-m-d'),
           'status' => $this->status,
           'subtotal' => Number::currency($this->total_price, 'BRL'),
           'quantity_items' => $this->quantity
        ];
    }
}
