<?php

namespace App\Api\V1\Http\Resources\Vehicle;

use Illuminate\Vehicles\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable
    {
        return [
            'id' => $this->id,
            'driver_id' => $this->driver_id,
            'name' => $this->name,
            'color' => $this->color,
            'type' => $this->type,
            'seat_number' => $this->seat_number,
            'license_plate' => $this->license_plate,
            'license_plate_image' => $this->license_plate_image,
            'vehicle_company' => $this->vehicle_company,
            'vehicle_registration_front' => $this->vehicle_registration_front,
            'vehicle_registration_back' => $this->vehicle_registration_back,
            'vehicle_front_image' => $this->vehicle_front_image,
            'vehicle_back_image' => $this->vehicle_back_image,
            'vehicle_side_image' => $this->vehicle_side_image,
            'vehicle_interior_image' => $this->vehicle_interior_image,
            'insurance_front_image' => $this->insurance_front_image,
            'insurance_back_image' => $this->insurance_back_image,
            'amenities' => $this->amenities,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'price' => $this->price,
            'status' => $this->status,
        ];
    }
}
