<?php

namespace App\maguttiCms\Notifications;

use App\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class ContactRequest extends Notification implements ShouldQueue
{
    use Queueable;

    public array $data;

    /**
     * Create a new notification instance.
     *
     * @param array $data
     */
    public function __construct( array $data)
    {
        //
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $this->data['messageLines'] = explode("\n", $this->data['message']);

        $subject = trans('website.mail_message.contact') . ': ' . $this->data['name']. ' ' . $this->data['company'];

        return (new MailMessage)
            ->subject($subject)
            ->replyTo($this->data['email'])
            ->view(['emails.contact.html', 'emails.contact.plain'], ['data' => $this->data]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [];
    }
}
