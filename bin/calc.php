#!/usr/bin/env php
<?php

require_once __DIR__ . '/../src/autoload.php';

use App\Interpreter\Interpreter;
use App\Parser\Parser;
use App\Tokenizer\Tokenizer;

$input = $argv[1];
$tokenizer = new Tokenizer($input);
$tokens = $tokenizer->tokens();
$parser = new Parser($tokens);
$ast = $parser->parse();
$interpreter = new Interpreter();
$interpreter->interpret($ast);
echo PHP_EOL;
