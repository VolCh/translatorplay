<?php

namespace App\Test\Tokenizer;

use App\Test\Test;
use App\Tokenizer\Token;
use App\Tokenizer\Tokenizer;
use Generator;

/**
 * Class TokenizerTest
 */
class TokenizerTest extends Test
{
    public function testEmpty(): void
    {
        $tokens= (new Tokenizer(''))->tokens();
        $this->assertTokens($tokens, []);
    }

    public function testOneDigitIntegerLiteral(): void
    {
        $tokens= (new Tokenizer('1'))->tokens();
        $this->assertTokens($tokens, [
            [
                'type' => Token::TYPE_INTEGER,
                'value' => 1,
            ],
        ]);
    }

    public function testIntegerLiteral(): void
    {
        $tokens= (new Tokenizer('12'))->tokens();
        $this->assertTokens($tokens, [
            [
                'type' => Token::TYPE_INTEGER,
                'value' => 12,
            ],
        ]);
    }

    public function testPlus(): void
    {
        $tokens= (new Tokenizer('12+34'))->tokens();
        $this->assertTokens($tokens, [
            [
                'type' => Token::TYPE_INTEGER,
                'value' => 12,
            ],
            [
                'type' => Token::TYPE_PLUS,
                'value' => '+',
            ],
            [
                'type' => Token::TYPE_INTEGER,
                'value' => 34,
            ],
        ]);
    }

    /**
     * @param Generator|Token[] $tokens
     * @param array[] $expectedTokensData
     */
    private function assertTokens($tokens, array $expectedTokensData): void
    {
        $index = 0;
        foreach ($tokens as $token) {
//            var_dump($token);
            $this->assertEquals(array_key_exists($index, $expectedTokensData), true);
            ['type' => $expectedType, 'value' => $expectedValue] = $expectedTokensData[$index];
            $this->assertEquals($token->type(), $expectedType);
            $this->assertEquals($token->value(), $expectedValue);
            $index++;
        }
        $this->assertEquals($index, count($expectedTokensData));
    }
}
