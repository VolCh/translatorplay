<?php

namespace App\Test\Parser;

use App\Parser\Parser;
use App\Test\Test;
use App\Tokenizer\Token;

/**
 * Class ParserTest
 */
class ParserTest extends Test
{
    public function testIntegerLiteral(): void
    {
        $tokens = static function () {
            yield new Token(Token::TYPE_INTEGER, 1);
        };
        $parser = new Parser($tokens());
        $tree = $parser->parse();
        $this->assertEquals($tree->asArray(), [
            'type' => 'IntegerLiteral',
            'value' => 1,
        ]);
    }

    public function testPlus(): void
    {
        $tokens = static function () {
            yield new Token(Token::TYPE_INTEGER, 1);
            yield new Token(Token::TYPE_PLUS, '+');
            yield new Token(Token::TYPE_INTEGER, 2);
        };
        $parser = new Parser($tokens());
        $tree = $parser->parse();
        $this->assertEquals($tree->asArray(), [
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

    public function testMinus(): void
    {
        $tokens = static function () {
            yield new Token(Token::TYPE_INTEGER, 1);
            yield new Token(Token::TYPE_PLUS, '-');
            yield new Token(Token::TYPE_INTEGER, 2);
        };
        $parser = new Parser($tokens());
        $tree = $parser->parse();
        $this->assertEquals($tree->asArray(), [
            'type' => 'BinaryOperator',
            'operator' => '-',
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

    public function testPlusMinusMinusPlus(): void
    {
        $tokens = static function () {
            yield new Token(Token::TYPE_INTEGER, 1);
            yield new Token(Token::TYPE_PLUS, '+');
            yield new Token(Token::TYPE_INTEGER, 2);
            yield new Token(Token::TYPE_MINUS, '-');
            yield new Token(Token::TYPE_INTEGER, 3);
            yield new Token(Token::TYPE_MINUS, '-');
            yield new Token(Token::TYPE_INTEGER, 4);
            yield new Token(Token::TYPE_PLUS, '+');
            yield new Token(Token::TYPE_INTEGER, 5);
        };
        $parser = new Parser($tokens());
        $tree = $parser->parse();
        $this->assertEquals($tree->asArray(), [
            'type' => 'BinaryOperator',
            'operator' => '+',
            'left' => [
                'type' => 'BinaryOperator',
                'operator' => '-',
                'left' => [
                    'type' => 'BinaryOperator',
                    'operator' => '-',
                    'left' => [
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
                    ],
                    'right' => [
                        'type' => 'IntegerLiteral',
                        'value' => 3,
                    ],
                ],
                'right' => [
                    'type' => 'IntegerLiteral',
                    'value' => 4,
                ],
            ],
            'right' => [
                'type' => 'IntegerLiteral',
                'value' => 5,
            ],
        ]);
    }
}
