#!/usr/bin/env php
<?php

use App\Test\Interpreter\InterpreterTest;
use App\Test\Parser\ParserTest;
use App\Test\Tokenizer\TokenizerTest;

if (ini_get('zend.assertions') !== '1') {
    throw new \Error('zend.assertions should be enable');
}

require_once __DIR__ . '/../src/Tokenizer/Token.php';
require_once __DIR__ . '/../src/Tokenizer/Tokenizer.php';
require_once __DIR__ . '/../src/Parser/Parser.php';
require_once __DIR__ . '/../src/Parser/Node/Node.php';
require_once __DIR__ . '/../src/Parser/Node/IntegerLiteral.php';
require_once __DIR__ . '/../src/Interpreter/Interpreter.php';
require_once __DIR__ . '/../test/Tokenizer/TokenizerTest.php';
require_once __DIR__ . '/../test/Parser/ParserTest.php';
require_once __DIR__ . '/../test/Interpreter/InterpreterTest.php';

$tokenizerTest = new TokenizerTest();
$tokenizerTest->testEmpty();
$tokenizerTest->testOneDigit();
$tokenizerTest->testDigits();
$tokenizerTest->testIntegerPlusInteger();

$parserTest = new ParserTest();
$parserTest->parseDigit();

$interpreterTest = new InterpreterTest();
$interpreterTest->testInteger();
