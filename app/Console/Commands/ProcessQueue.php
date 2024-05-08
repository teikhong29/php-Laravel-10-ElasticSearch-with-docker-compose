<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class ProcessQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process tasks from the Redis queue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $queueName = 'tasks';

        $this->info("Queue is runing...");

        while (true) {
            $task = Redis::lpop($queueName);

            if ($task !== null) {
                // Process the task
                $this->info("Processing task: $task");
            } else {
                $this->info("No tasks in the queue.");
                sleep(1);
            }
        }

        $this->info("Queue processing completed.");
    }
}
