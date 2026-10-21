<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Borrow;

class NotificationController extends Notification
{
    use Queueable;

    protected $borrow;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct(Borrow $borrow, string $type = 'upcoming')
    {
        $this->borrow = $borrow;
        $this->type = $type;
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
        $bookTitle = $this->borrow->book->title ?? '';
        $dueDate = $this->borrow->due_at->format('M d, Y');

        $mail = (new MailMessage)
            ->subject($this->type === 'overdue' ? 'OVERDUE: Library Book Return Notice' : 
            'Reminder: Upcoming Book Due Date');
        
        if ($this->type === 'overdue') {
            $mail->greeting('Hello ' . $notifiable->name . ',')
                ->line('This is a notice that your borrowed book, "' . $bookTitle . '", was due on ' . $dueDate . '.')
                ->line('Please retrun it to the library as soon as possible to avoid fines');
        } else {
            $mail->greeting('Hello ' . $notifiable->name . ',')
                ->line('This is a friendly reminder that your borrowed book, "' . $bookTitle . '", is due on ' . $dueDate . '.')
                ->line('Please ensure it is returned on time');
        }
        return $mail->action('View Dashboard', url('/dashboard'));
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
