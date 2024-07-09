<?php

namespace App\Admin\Http\Requests\Notification;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Notification\NotificationStatus;
use Illuminate\Validation\Rules\Enum;

class NotificationRequest extends BaseRequest
{
    protected function methodGet(): array
    {
        return [
            'admin_id' => 'required|exists:admins,id',

        ];
    }

    protected function methodPost(): array
    {
        return [
            'title' => ['required', 'string'],
            'message' => ['required'],
            'user_id.*' => ['nullable'],
            'device_token' => ['required'],
            'status' => ['required', new Enum(NotificationStatus::class)],
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Notification,id'],
            'title' => ['required', 'string'],
            'device_token' => ['required'],
            'message' => ['required'],
            'user_id' => ['nullable'],
            'status' => ['required', new Enum(NotificationStatus::class)],
        ];
    }
    protected function methodPatch(): array
    {
        return [
            'admin_id' => 'required|exists:admins,id',
        ];
    }
}
