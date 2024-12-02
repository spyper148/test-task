<?php

namespace Lib\Services\Import\Parsers\JsonPlaceholder;

use Lib\Services\Import\Dto\CommentDto;
use Lib\Services\JsonPlaceholderClient\JsonPlaceholderClient;

class JsonPlaceholderCommentsParser
{
    protected JsonPlaceholderClient $client;

    public function __construct()
    {
        $this->client = new JsonPlaceholderClient();
    }

    public function parse(): array
    {
        $comments = $this->client->comments();
        $result = [];

        foreach ($comments as $comment) {
            $result[] = $this->getDto($comment);
        }

        return $this->groupByPost($result);
    }

    protected function getDto(array $data): CommentDto
    {
        return new CommentDto(
            id: $data["id"],
            body: $data["body"],
            name: $data["name"],
            email: $data["email"],
            postId: $data["postId"],
        );
    }

    /**
     * @param CommentDto[] $comments
     * @return array
     */
    protected function groupByPost(array $comments): array
    {
        $uniquePosts = $this->uniquePosts($comments);
        $result = [];

        foreach ($uniquePosts as $post) {
            $result[$post] = $this->findPostComments($comments, $post);
        }

        return $result;
    }

    protected function uniquePosts(array $comments): array
    {
        $uniquePosts = [];

        foreach ($comments as $comment) {
            if (!in_array($comment->postId, $uniquePosts)) {
                $uniquePosts[] = $comment->postId;
            }
        }

        return $uniquePosts;
    }

    protected function findPostComments(array $comments, int $postId): array
    {
        return array_filter($comments, fn(CommentDto $comment) => $comment->postId === $postId);
    }
}