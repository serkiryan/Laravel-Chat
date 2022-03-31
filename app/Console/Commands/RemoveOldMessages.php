<?php

namespace App\Console\Commands;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RemoveOldMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'LaravelChat:RemoveOldMessages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes old messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiry_date = Carbon::now()->subDay();

        Message::where('created_at', '<', $expiry_date)->delete();

        return 0;
    }
}
