#!/usr/bin/env php
<?php

require_once __DIR__ . '/../src/autoload.php';
require_once __DIR__ . '/../test/Test.php';
require_once __DIR__ . '/../test/Tokenizer/TokenizerTest.php';
require_once __DIR__ . '/../test/Parser/ParserTest.php';
require_once __DIR__ . '/../test/Interpreter/InterpreterTest.php';

use App\Test\Interpreter\InterpreterTest;
use App\Test\Parser\ParserTest;
use App\Test\Tokenizer\TokenizerTest;

if (ini_get('zend.assertions') !== '1') {
    throw new \Error('zend.assertions should be enable');
}

$tokenizerTest = new TokenizerTest();
$tokenizerTest->runAll();

$parserTest = new ParserTest();
$parserTest->runAll();

$interpreterTest = new InterpreterTest();
$interpreterTest->runAll();
