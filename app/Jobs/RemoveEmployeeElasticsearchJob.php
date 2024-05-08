<?php

namespace App\Jobs;

use App\Models\Employee;
use Elastic\Elasticsearch\ClientBuilder;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveEmployeeElasticsearchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employeeId;

    /**
     * Create a new job instance.
     */
    public function __construct($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = ClientBuilder::create()->setHosts(['elasticsearch:9200'])->build();
        $params = [
            'index' => 'employees',
            'id' => $this->employeeId,
        ];

        $client->delete($params);
    }
}
