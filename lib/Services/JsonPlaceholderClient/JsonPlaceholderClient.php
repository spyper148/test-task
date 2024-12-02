<?php

namespace Lib\Services\JsonPlaceholderClient;

use GuzzleHttp\Client;

class JsonPlaceholderClient
{
    protected Client $httpClient;
    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => getenv("JSONPLACEHOLDER_URL"),
        ]);
    }
    public function posts(): array
    {
        $response = $this->httpClient->get("posts");
        return json_decode($response->getBody(),true);
    }

    public function comments(): array
    {
        $response = $this->httpClient->get("comments");
        return json_decode($response->getBody(),true);
    }

}