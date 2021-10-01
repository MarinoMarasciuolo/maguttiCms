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


    private Contact $contact;

    /**
     * Create a new notification instance.
     *
     * @param Contact $contact
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
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

        $subject = trans('website.mail_message.contact') . ': ' . $this->contact->name. ' ' . $this->contact->company;

        return (new MailMessage)
            ->subject($subject)
            ->replyTo($this->contact->email)
            ->view(['emails.contact.html', 'emails.contact.plain'], ['contact' => $this->contact]);
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
