<?php

namespace Lib\Services\Import\Parsers\JsonPlaceholder;

use Lib\Services\Import\Dto\PostDto;
use Lib\Services\JsonPlaceholderClient\JsonPlaceholderClient;

class JsonPlaceholderPostsParser
{
    protected JsonPlaceholderClient $client;

    public function __construct()
    {
        $this->client = new JsonPlaceholderClient();
    }
    public function parse(): array 
    {
        $posts = $this->client->posts();
        $result = [];

        foreach ($posts as $post) {
            $result[] = $this->getPostDto($post);
        }

        return $result;
    }  

    protected function getPostDto(array $data): PostDto
    {
        return new PostDto(
            id: $data["id"],
            title: $data["title"],
            body: $data["body"],
            userId: $data["userId"],
        );
    }
}