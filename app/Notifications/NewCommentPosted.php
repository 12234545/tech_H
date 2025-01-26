<?php

namespace App\Notifications;

use App\Models\article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\user;
use App\Models\comment;


class NewCommentPosted extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $user;
    protected $comment;
    protected $article;
    public function __construct(article $article , user $user , comment $comment)
    {
        $this->user = $user;
        $this->article = $article;
        $this->comment = $comment;
    }




    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'titreArticle' => $this->article->title,
            'article_id' => $this->article->id,
            'user_name' => $this->user->name,
            'comment_id' => $this->comment->id,
            'notification_type' => $this->comment->commentable_type === Comment::class ? 'reply' : 'comment'
        ];
    }

}
