<?php

namespace App\Api\V1\Repositories\Notification;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface NotificationRepositoryInterface extends EloquentRepositoryInterface
{
    public function getAll();

    public function delete($id);
    public function getNotificationById($role, $userId);
}
