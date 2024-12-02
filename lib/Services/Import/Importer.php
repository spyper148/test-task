<?php

namespace Lib\Services\Import;

use Lib\Services\Import\Dto\ImportResult;
use Lib\Services\Import\Importers\CommentsImporter;
use Lib\Services\Import\Importers\PostsImporter;
use Lib\Services\Import\Parsers\Interfaces\Parser;
use Lib\Services\Import\Parsers\JsonPlaceholder\JsonPlaceholderParser;

class Importer
{
    protected PostsImporter $postsImporter;

    protected CommentsImporter $commentsImporter;

    public function __construct()
    {
        $this->postsImporter = new PostsImporter();
        $this->commentsImporter = new CommentsImporter();
    }

    public function import(): ImportResult
    {
        $parseResult = $this->parser()->parse();

        return new ImportResult(
            postImportedCount: $this->postsImporter->import($parseResult->posts),
            commentImportedCount: $this->commentsImporter->import($parseResult->comments),
        );
    }

    protected function parser(): Parser
    {
        $parser = match (getenv('PARSER')) {
            'jsonplaceholder' => JsonPlaceholderParser::class,
        };

        return new $parser();
    }

}