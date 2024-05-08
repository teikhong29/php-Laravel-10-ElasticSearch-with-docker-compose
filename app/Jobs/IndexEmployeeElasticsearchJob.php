<?php

namespace App\Jobs;

use App\Models\Employee;
use Elastic\Elasticsearch\ClientBuilder;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IndexEmployeeElasticsearchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employee;

    /**
     * Create a new job instance.
     */
    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = ClientBuilder::create()->setHosts(['elasticsearch:9200'])->build();

        $params = [
            'index' => 'employees',
            'id' => $this->employee->id,
            'body' => [
                'firstname' => $this->employee->firstname,
                'lastname' => $this->employee->lastname,
                'email' => $this->employee->email,
                'address' => $this->employee->address,
                'phone' => $this->employee->phone,
            ]
        ];

        $client->index($params);
    }
}
