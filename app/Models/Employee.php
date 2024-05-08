<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Elastic\Elasticsearch\ClientBuilder;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['firstname', 'lastname', 'email', 'address', 'phone'];

    public static function createIndex()
    {
        // $client = ClientBuilder::create()
        //     ->setHosts(['elasticsearch:9200'])
        //     ->build();
        $client = ClientBuilder::create()->setHosts(['elasticsearch:9200'])->build();

        $params = [
            'index' => 'employees',
            'body' => [
                'mappings' => [
                    'properties' => [
                        'firstname' => ['type' => 'text'],
                        'lastname' => ['type' => 'text'],
                        'email' => ['type' => 'text'],
                        'address' => ['type' => 'text'],
                        'phone' => ['type' => 'text'],
                    ]
                ]
            ]
        ];

        try{
            $client->indices()->create($params);
        }
        catch (\Exception $e) {
            // Handle the exception (e.g., log the error or display a user-friendly message)
        }
    }
}
