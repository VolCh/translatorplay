<?php

namespace App\Tokenizer;

use Generator;
use InvalidArgumentException;

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
        if ($input === '') {
            $token = new Token(Token::TYPE_EOF, null);
        } elseif (preg_match('/^\d$/', $input) === 1) {
            $token = new Token(Token::TYPE_INTEGER, (int)$input);
        } else {
            throw new InvalidArgumentException('Unexpected symbol ' . $input);
        }
        yield $token;
    }
}
