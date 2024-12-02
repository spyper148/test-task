<?php

namespace Lib\Services\Import\Dto;

readonly class ParseResult
{
    /**
     * @param PostDto[] $posts
     * @param CommentDto[] $comments
     */

    public function __construct(
        public array $posts,
        public array $comments,
    )
    {
    }
}