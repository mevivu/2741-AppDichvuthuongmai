<?php

namespace App\Api\V1\Http\Resources\Store;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        $roles = $this->roles->pluck('name');
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'area_id' => $this->area_id,
            'code' => $this->code,
            'slug' => $this->slug,
            'username' => $this->username,
            'store_name' => $this->store_name,
            'store_phone' => $this->store_phone,
            'contact_name' => $this->contact_name,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'logo' => $this->logo,
            'address' => $this->address,
            'address_detail' => $this->address_detail,
            'tax_code' => $this->tax_code,
            'open_hours_1' => $this->open_hours_1,
            'close_hours_1' => $this->close_hours_1,
            'open_hours_2' => $this->open_hours_2,
            'close_hours_2' => $this->close_hours_2,
            'status' => $this->status,
            'priority' => $this->priority,
            'lng' => $this->lng,
            'lat' => $this->lat,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'roles' => $roles,
        ];
    }
}
