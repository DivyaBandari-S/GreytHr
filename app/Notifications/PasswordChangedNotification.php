<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Request;
use Torann\GeoIP\Facades\GeoIP;
class PasswordChangedNotification extends Notification
{
    use Queueable;

    protected $companyName;
    protected $ipAddress;
    protected $location;
    protected $browser;

    /**
     * Create a new notification instance.
     */
    public function __construct($companyName)
    {
        $this->companyName = $companyName;
        $this->ipAddress = Request::ip(); // Get the user's IP address
        $this->location = GeoIP::getLocation($this->ipAddress); // Get location based on IP
        $this->browser = Request::header('User-Agent'); // Get the User-Agent (browser) information
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
                'companyName' => $this->companyName,
                'logoUrl' => asset('images/hr_new_white.png'),
                'ipAddress' => $this->ipAddress,
                'location' => $this->location,
                'browser' => $this->browser,
            ]);
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