#!/usr/bin/env php
<?php

use App\Test\Tokenizer\TokenizerTest;

if (ini_get('zend.assertions') !== '1') {
    throw new \Error('zend.assertions should be enable');
}

require_once __DIR__ . '/../src/Tokenizer/Token.php';
require_once __DIR__ . '/../src/Tokenizer/Tokenizer.php';
require_once __DIR__ . '/../test/Tokenizer/TokenizerTest.php';

$testSuite = new TokenizerTest();
$testSuite->testEmpty();
