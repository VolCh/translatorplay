#!/usr/bin/env php
<?php

use App\Interpreter\Interpreter;
use App\Parser\Parser;
use App\Tokenizer\Tokenizer;

require_once __DIR__ . '/../src/Tokenizer/Token.php';
require_once __DIR__ . '/../src/Tokenizer/Tokenizer.php';
require_once __DIR__ . '/../src/Parser/Parser.php';
require_once __DIR__ . '/../src/Parser/Node/Node.php';
require_once __DIR__ . '/../src/Parser/Node/IntegerLiteral.php';
require_once __DIR__ . '/../src/Interpreter/Interpreter.php';

$input = $argv[1];
$tokenizer = new Tokenizer();
$tokens = Tokenizer::createGenerator($input);
$parser = new Parser($tokens);
$ast = $parser->parse();
$interpreter = new Interpreter();
$interpreter->interpret($ast);
echo PHP_EOL;
