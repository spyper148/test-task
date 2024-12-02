<?php

namespace Lib\Services\Import\Parsers\JsonPlaceholder;

use Lib\Services\Import\Dto\ParseResult;
use Lib\Services\Import\Parsers\Interfaces\Parser;

class JsonPlaceholderParser implements Parser
{
    protected JsonPlaceholderCommentsParser $commentsParser;

    protected JsonPlaceholderPostsParser $postsParser;

    public function __construct()
    {
        $this->commentsParser = new JsonPlaceholderCommentsParser();
        $this->postsParser = new JsonPlaceholderPostsParser();
    }
    public function parse(): ParseResult
    {
        return new ParseResult(
            posts: $this->postsParser->parse(),
            comments: $this->commentsParser->parse(),
        );
    }
}