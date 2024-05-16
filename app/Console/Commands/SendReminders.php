<?php

namespace App\Console\Commands;

use App\Models\Reminder;
use App\Notifications\ReminderNotification;
use Illuminate\Console\Command;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reminders = Reminder::where('datetime', '<=', now())->where('is_active', true)->get();
        foreach ($reminders as $reminder) {
            $user = $reminder->quest->user;
            $user->notify(new ReminderNotification($reminder));
            $reminder->update(['is_active' => false]);
        }

        $this->info('Reminders sent successfully!');
    }
}
