<?php

namespace Lib\Services\Import\Dto;

readonly class ImportResult
{
    public function __construct(
        public int $postImportedCount,
        public int $commentImportedCount,
    )
    {
    }
}