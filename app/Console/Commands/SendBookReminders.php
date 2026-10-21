<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Borrow;
use App\Notifications\NotificationController;
use Carbon\Carbon;

class SendBookReminders extends Command
{
    protected $signature = 'library:send-book-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders for upcoming due dates and overdue books';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $tomorrow = Carbon::tomorrow();

        // 1. Send reminders for books due tomorrow
        $upcomingBorrows = Borrow::with(['user', 'book'])
            ->where('status', 'borrowed')
            ->whereDate('due_at', $tomorrow->toDateString())
            ->get();

        foreach ($upcomingBorrows as $borrow) {
            if ($borrow->user && $borrow->user->email) {
                $borrow->user->notify(new NotificationController($borrow, 'upcoming'));
            }
        }

        // 2. Send notices for books that are overdue (due date was yesterday or earlier, still borrowed)
        $overdueBorrows = Borrow::with(['user', 'book'])
            ->where('status', 'borrowed')
            ->where('due_at', '<', $now->startOfDay())
            ->get();

        foreach ($overdueBorrows as $borrow) {
            if ($borrow->user && $borrow->user->email) {
                $borrow->user->notify(new NotificationController($borrow, 'overdue'));
            }
        }

        $this->info('Library email reminders sent successfully!');
    }
}
