<?php

namespace App\Api\V1\Http\Resources\Driver;

use App\Api\V1\Http\Resources\Auth\AuthResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'user' => new AuthResource($this->user),
            'id_card' => $this->id_card,
            'license_plate' => $this->license_plate,
            'vehicle_company' => $this->vehicle_company,
            'bank_name' => $this->bank_name,
            'bank_account_name' => $this->bank_account_name,
            'bank_account_number' => $this->bank_account_number,
            'auto_accept' => $this->auto_accept,
            'current_lat' => $this->current_lat,
            'current_lng' => $this->current_lng,
            'current_address' => $this->current_address,
            'order_accepted' => $this->order_accepted,
            'is_locked' => $this->is_locked,
            'is_on' => $this->is_on,
            'images' => [
                'id_card_front' => $this->id_card_front,
                'avatar' => $this->user->avatar,
                'id_card_back' => $this->id_card_back,
                'license_plate_image' => $this->license_plate_image,
                'vehicle_registration_front' => $this->vehicle_registration_front,
                'vehicle_registration_back' => $this->vehicle_registration_back,
                'driver_license_front' => $this->driver_license_front,
                'driver_license_back' => $this->driver_license_back,
                'vehicle_front_image' => $this->vehicle_front_image,
                'vehicle_back_image' => $this->vehicle_back_image,
                'vehicle_side_image' => $this->vehicle_side_image,
                'vehicle_interior_image' => $this->vehicle_interior_image,
                'insurance_front_image' => $this->insurance_front_image,
                'insurance_back_image' => $this->insurance_back_image,
            ]
        ];
    }
}
