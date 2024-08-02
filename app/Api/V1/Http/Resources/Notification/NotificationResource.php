<?php

namespace App\Api\V1\Http\Resources\Notification;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function($notification){
            $data = [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
                'status' => $notification->status,
                'created_at' => $notification->created_at,
            ];

            return $data;
        });
    }
}
