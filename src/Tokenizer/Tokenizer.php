<?php

namespace App\Tokenizer;

use Generator;

/**
 * Class Tokenizer
 */
class Tokenizer
{
    /**
     * @param string $input String to parse
     * @return Generator|Token[] Generator of Token stream
     */
    public static function createGenerator(string $input): Generator
    {
        $token = new Token(Token::TYPE_EOF, null);
        yield $token;
    }
}
