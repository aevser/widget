<?php

namespace App\Http\Resources\V1\Ticket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexTicketResource extends JsonResource
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
            'customer_id' => $this->customer_id,
            'status_id' => $this->status_id,
            'subject' => $this->subject,
            'message' => $this->message,
            'manager_replied_at' => $this->manager_replied_at,
            'customer' => [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'phone' => $this->customer->phone,
                'email' => $this->customer->email,
            ],
            'status' => [
                'id' => $this->status->id,
                'name' => $this->status->name,
                'type' => $this->status->type
            ]
        ];
    }
}
