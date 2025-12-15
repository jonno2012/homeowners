<?php

declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

use Jonat\Homeowners\HomeownerParser;

$parser = new HomeownerParser();
$people = $parser->parseCsv(__DIR__ . '/examples.csv');

echo json_encode($people, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";

