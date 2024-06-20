<?php

namespace App\Traits;

use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Enums\Notification\NotificationStatus;
use App\Models\Order;

trait HandlesNotifications
{
    /**
     * Create and save a new notification in the database.
     * @param string $type Type of notification (new_order, order_cancelled, etc.)
     */
    public function createNotification($entity, $order, $entityType, string $type): void
    {
        $notificationRepository = app(NotificationRepositoryInterface::class);
        $notificationData = $this->createNotificationData($entity, $order, $entityType, $type);

        $notificationRepository->create($notificationData);
    }

    public function createNotificationData($entity, $order, $entityType, $type): array
    {
        $titleTemplate = config("notifications.{$type}.title");
        $title = str_replace('#ORDER_ID#', $order->code, $titleTemplate);

        $message = $this->formatNotificationMessage($order, config("notifications.{$type}.message"));

        return [
            'user_id' => $order->customer_id,
            $entityType => $entity->id,
            'title' => $title,
            'message' => $message,
            'type' => Order::class,
            'status' => NotificationStatus::NOT_READ,
        ];
    }

    /**
     * Format the notification message with a dynamic prefix.
     */
    public function formatNotificationMessage($order, $prefixMessage): string
    {
        $message = str_replace('#ORDER_ID#', $order->code, $prefixMessage);
        return $message . " " . $order->customer->fullname;
    }

    public function strReplaceOrderCode(string $title, $order): array|string
    {
        return str_replace('#ORDER_ID#', $order->code, $title);
    }
}
