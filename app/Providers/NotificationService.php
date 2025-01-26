namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public static function create($userId, $type, $title, $content, $relatedId = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'content' => $content,
            'related_id' => $relatedId,
            'is_read' => false
        ]);
    }
}
