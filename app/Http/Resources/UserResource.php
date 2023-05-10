<?php 

namespace App\Http\Resources;

use GuzzleHttp\Psr7\Request;
use Illuminate\Http\JsonResponse;
use Nette\Utils\DateTime;

class UserResource extends JsonResponse {

    public static $wrap = false;

     /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    
    public function toArray(Request $request): array {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];

    }
}