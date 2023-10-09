<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\UserNotification;

class NotifyUsers extends Command
{
    protected $signature = 'notifications:send';
    protected $description = 'Send scheduled notifications';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();

        $notifications = UserNotification::where('scheduled_at', '<=', $now->toTimeString())
            ->where(function ($query) use ($now) {
                $query->whereNull('last_sent_at')
                    ->orWhere(function ($subquery) use ($now) {
                        $subquery->where('frequency', 'custom')
                            ->where('last_sent_at', '<', $now->subMinutes(30)->toDateTimeString());
                    });
            })
            ->get();

        foreach ($notifications as $notification) {

            $notification->update(['last_sent_at' => $now]);
        }

        $this->info('Notifications sent successfully.');
    }
}
