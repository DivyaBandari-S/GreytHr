<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class RegularisationApproved extends Notification
{
    use Queueable;

    protected $employee;
    /**
     * Create a new notification instance.
     */
    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['twilio'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }
    public function toTwilio($notifiable)
    {
        // Get the employee's mobile number
        $mobileNumber = $this->employee->emergency_contact;

        // Get Twilio credentials
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.from');

        // Initialize Twilio client
        $client = new Client($sid, $token);

        // Send SMS
        $client->messages->create(
            $mobileNumber, // The recipient's phone number
            [
                'from' => $from, // Your Twilio phone number
                'body' => "Hello , your regularisation request has been approved. Thank you!"
            ]
        );
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
