<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class HomeController extends Controller
{

    protected $client;

    public function __construct () {

        $this->client = ClientBuilder::create()
                    ->setElasticCloudId(config('elasticsearch.cloud_id'))
                    ->setApiKey(config('elasticsearch.api_key'))
                    ->build();

    }


    public function search () {

        $params = [
            'index' => 'my_index',
            'body'  => [
                'query' => [
                    'match' => [
                        'testField' => 'abc'
                    ]
                ]
            ]
        ];

        $response = $this->client->search($params);

        dd($response->asArray());
    }


    public function index () {

        $client = ClientBuilder::create()
                    ->setElasticCloudId(config('elasticsearch.cloud_id'))
                    ->setApiKey(config('elasticsearch.api_key'))
                    ->build();

        // Create
        /*
        $params = [
            "index" => "sample_index",
            "id"    => "sampleId",
            "body"  => [
                "price"     => "3000",
                "name"      => "sample product",
                "description"   => "my description"
            ]
        ];

        $response = $client->index($params);
        dd($response->asArray());
        */

        // GET
        /*
        $params = [
            "index" => "sample_index",
            "id"    => "sampleId"
        ];

        $response = $client->get($params);
        dd($response->asArray());
        */

        // UPDATE
        /*
        $params = [
            "index" => "sample_index",
            "id"    => "sampleId",
            "body"  => [
                "doc"   => [
                    "price" => "500000"
                ]
            ]
        ];

        $response = $client->update($params);
        dd($response->asArray());
        */

        // DELETE
        /*
        $params = [
            "index" => "sample_index",
            "id"    => "sampleId"
        ];

        $response = $client->delete($params);
        dd($response->asArray());
        */

        // DELETE Indices
        /*
        $params = [
            "index" => "sample_index"
        ];

        $response = $client->indices()->delete($params);
        dd($response->asArray());
        */

    }

    public function index_1 () {

        $params = [
            'index' => 'my_index',
            'body'  => [ 'testField' => 'abc']
        ];

        try {
            
            $response = $this->client->index($params);

        } catch (ClientResponseException $e) {

            // manage the 4xx error
            dump('manage the 4xx error');
            dd($e->getMessage());
        } catch (ServerResponseException $e) {

            // manage the 5xx error
            dump('manage the 5xx error');
            dd($e->getMessage());
        } catch (Exception $e) {

            // eg. network error like NoNodeAvailableException
            dump('eg. network error like NoNodeAvailableException');
            dd($e->getMessage());
        }

        dd($response->asArray());  // response body content as array
    }


}
