<?php

namespace App\Admin\Http\Resources\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverSearchSelectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->user->fullname.' - '.$this->user->phone
        ];
    }
}
