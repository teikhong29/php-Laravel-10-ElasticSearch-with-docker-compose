<?php

namespace App\Console\Commands;

use App\Services\RabbitMQService;
use App\Models\Employee;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RabbitMQConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:consumer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    
    public function handle()
    {
        $this->info("RabbitMQ is runing...");
        $rabbitMQService = new RabbitMQService();
        $rabbitMQService->consume(function ($msg) {
            $data = json_decode($msg->body, true);

            // Store data in MYSQL database
            $employee = Employee::create($data);
            
            // Store data in Redis Hashes
            Redis::hset('emp_key', $employee->id, json_encode($employee));

            $this->info("Message processed: " . $msg->body);
        });
    }
}
