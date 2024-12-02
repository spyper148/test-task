<?php

namespace Lib\Services\Import\Dto;

readonly class CommentDto
{
    public function __construct(
        public int $id,
        public string $body,
        public string $name,
        public string $email,
        public int $postId
    )
    {
    }
}