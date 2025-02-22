<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Article;
use Illuminate\Support\Facades\Log;

class ArticleRecommendation extends Notification
{
    use Queueable;
    protected $article;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
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
    /*
    public function toArray($notifiable)
    {
        return [
            'article_id' => $this->article->id,
            'titreArticle' => $this->article->title,
            'notification_type' => 'recommendation'
        ];
    }
        */

        /*
        public function toArray($notifiable)
        {
            $data = [
                'article_id' => $this->article->id,
                'titreArticle' => $this->article->title,
                'notification_type' => 'recommendation',
                'user_name' => 'Système' // Ajout d'un nom d'utilisateur pour la cohérence
            ];

            Log::info('Création notification avec données: ', $data);

            return $data;
        }
            */
            public function toArray($notifiable)
            {
                return [
                    'article_id' => $this->article->id,
                    'titreArticle' => $this->article->title,
                    'notification_type' => 'recommendation',
                    'user_name' => 'Système', // Nom de l'expéditeur
                ];
            }

}
