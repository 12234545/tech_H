<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\article;
use App\Models\User;

class NewRatingPosted extends Notification
{
    use Queueable;

    protected $article;
    protected $rater;
    protected $rating;



    public function __construct(Article $article, User $rater, int $rating)
    {
        $this->article = $article;
        $this->rater = $rater;
        $this->rating = $rating;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'article_id' => $this->article->id,
            'titreArticle' => $this->article->title,
            'user_name' => $this->rater->name,
            'rating' => $this->rating,
            'notification_type' => 'rating'
        ];
    }
}
