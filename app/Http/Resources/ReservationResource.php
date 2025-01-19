<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ref_number' => $this->ref_number,
            'fullname' => $this->fullname,
            'checkin' => $this->checkin->format('Y-m-d h:i'),
            'checkout' => $this->created_at->format('Y-m-d h:i'),
        ];
    }
}
