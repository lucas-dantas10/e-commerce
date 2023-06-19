<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{

    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $billing = $this->billingAddresses;
        $shipping = $this->shippingAddresses;
        return [
            'id' => $this->user_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->user->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new DateTime($this->updated_at))->format('Y-m-d H:i:s'),

            'shippingAddress' => [
                'id' => $shipping->id,
                'address1' => $shipping->address1,
                'address2' => $shipping->address2,
                'city' => $shipping->city,
                'state' => $shipping->state,
                'zipcode' => $shipping->zipcode,
                'country_code' => $shipping->country->code,
            ],

            'billingAddress' => [
                'id' => $billing->id,
                'address1' => $billing->address1,
                'address2' => $billing->address2,
                'city' => $billing->city,
                'state' => $billing->state,
                'zipcode' => $billing->zipcode,
                'country_code' => $billing->country->code,
            ]
        ];
    }
}
