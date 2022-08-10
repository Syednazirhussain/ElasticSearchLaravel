<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Elastic\Elasticsearch\ClientBuilder;

class PostController extends Controller
{
    
    protected $client;

    public function __construct () {

        $this->client = ClientBuilder::create()
                    ->setElasticCloudId(config('elasticsearch.cloud_id'))
                    ->setApiKey(config('elasticsearch.api_key'))
                    ->build();
    }

    public function insert () {

        $posts = Post::all()->toArray();


        $params = [
            'index' => 'posts',
            'body'  => [ 'posts' => $posts ]
        ];

        \Log::info($params);

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

    public function search () {

        $params = [
            'index' => 'posts',
            'body'  => [
                'query' => [
                    'match' => [
                        'posts' => 'Vero iste et voluptas laborum'
                    ]
                ]
            ]
        ];

        $response = $this->client->search($params);

        dd($response->asArray());

    }

}
