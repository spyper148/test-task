<?php

use Lib\App;
use Lib\Services\Import\Importer;

require __DIR__ . '/../../vendor/autoload.php';

App::configure();

$importer = new Importer();
$importResult = $importer->import();

echo "Загружено {$importResult->postImportedCount} записей и {$importResult->commentImportedCount} комментариев\n";
