<?php

namespace App\Test\Parser;

use App\Parser\Parser;
use App\Tokenizer\Token;

/**
 * Class ParserTest
 */
class ParserTest
{
    public function parseIntegerLiteral(): void
    {
        $tokens = static function () {
            yield new Token(Token::TYPE_INTEGER, 1);
        };
        $parser = new Parser($tokens());
        $tree = $parser->parse();
        assert($tree->asArray() === [
            'type' => 'IntegerLiteral',
            'value' => 1,
        ]);
    }

    public function parseIntegerPlusInteger(): void
    {
        $tokens = static function () {
            yield new Token(Token::TYPE_INTEGER, 1);
            yield new Token(Token::TYPE_PLUS, '+');
            yield new Token(Token::TYPE_INTEGER, 2);
        };
        $parser = new Parser($tokens());
        $tree = $parser->parse();
        assert($tree->asArray() === [
            'type' => 'BinaryOperator',
            'operator' => '+',
            'left' => [
                    'type' => 'IntegerLiteral',
                    'value' => 1,
                ],
            'right' => [
                'type' => 'IntegerLiteral',
                'value' => 2,
            ],
        ]);
    }
}
