<?php

namespace App\Api\V1\Repositories\Notification;
use \App\Admin\Repositories\Notification\NotificationRepository as AdminArea;
use App\Models\Notification;

class NotificationRepository extends AdminArea implements NotificationRepositoryInterface
{
    protected $model;

    public function __construct(Notification $note)
    {
        $this->model = $note;
    }

    public function get()
    {
        return $this->model->get();
    }
    public function detail($id)
    {
        return $this->model->detail($id);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
    public function getNotificationById($role, $userId)
    {
        if($userId){
            return $this->model->where($role, $userId)->paginate(5);
        }
        return false;
    }
}
