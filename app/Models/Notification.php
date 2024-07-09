<?php

namespace App\Models;

use App\Enums\Notification\NotificationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends  Model
{
    use HasFactory;
    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'admin_id',
        'store_id',
        'title',
        'message',
        'type',
        'status',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    protected $casts = [
        'status' => NotificationStatus::class,
    ];
    const STATUS_UNREAD = 1;
    const STATUS_READ = 2;
    // Cập nhật trạng thái của thông báo
    public function markAsRead() {
        $this->status = self::STATUS_READ;
        $this->save();
    }

    public function scopeUnread($query)
    {
        return $query->where('status', NotificationStatus::NOT_READ);
    }

}
