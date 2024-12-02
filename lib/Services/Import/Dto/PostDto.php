<?php

namespace Lib\Services\Import\Dto;

readonly class PostDto
{
    public function __construct(
        public int $id,
        public string $title,
        public string $body,
        public int $userId,
    )
    {
    }
}