<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'role' => $this->role,
            'slug' => $this->slug,
            'createdAt' => $this->created_at,
            'createdBy' => $this->whenLoaded('createdBy', function () {
                return [
                    'username' => $this->createdBy->username,
                    'employeeName' => $this->createdBy->employee->firstname . " " .  $this->createdBy->employee->lastname ?? null
                ];
            }),
        ];
    }
}
