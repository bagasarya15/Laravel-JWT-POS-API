<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'nik' => $this->nik,
            'firstName' => $this->firstname,
            'lastName' => $this->lastname,
            'lastEducation' => $this->last_education,
            'createdAt' => $this->created_at,
            'createdBy' => $this->created_by
        ];
    }
}
