<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StockThresholdNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */


    public function __construct(public Product $product)
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Seuil de Stock Atteint')
            ->line("Le produit '{$this->product->name}' a atteint son seuil minimum.")
            ->line("Quantité actuelle : {$this->product->quantity_in_stock}")
            ->action('Voir le produit', url("/products/{$this->product->id}/edit"))
            ->line('Veuillez réapprovisionner ce produit rapidement.');

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
