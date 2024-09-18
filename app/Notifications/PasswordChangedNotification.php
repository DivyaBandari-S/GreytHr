<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChangedNotification extends Notification
{
    use Queueable;

    protected $companyName;
    /**
     * Create a new notification instance.
     */
    public function __construct($companyName)
    {
        $this->companyName = $companyName;
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

    public function toMail($notifiable)
    {

        return (new MailMessage)
            ->subject('Your Password Has Been Changed')
            ->view('emails.password_changed', [
                'user' => $notifiable,
                'companyName' => $this->companyName, // Access the company name through the relationship
                'logoUrl' => asset('images/hr_new_white.png'),
            ]); // Use the 'view' method to load the custom Blade template
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