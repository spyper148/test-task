<?php

namespace Lib\Services\Import\Parsers\Interfaces;

use Lib\Services\Import\Dto\ParseResult;

interface Parser
{
    public function parse(): ParseResult;
}