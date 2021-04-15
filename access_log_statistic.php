<?php

namespace TestProject;

require_once "vendor/autoload.php";

use src\AccessLogStatistic;

$filePath = $argv[1];
$logParserGenerator = new AccessLogStatistic($filePath);
$error = $logParserGenerator->validation();
$error ?: exit($error);
print_r($logParserGenerator->getStatistic());
