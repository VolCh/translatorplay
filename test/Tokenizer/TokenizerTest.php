<?php

namespace App\Test\Tokenizer;

use App\Tokenizer\Token;
use App\Tokenizer\Tokenizer;
use Generator;

/**
 * Class TokenizerTest
 */
class TokenizerTest
{
    public function testEmpty(): void
    {
        $tokens= (new Tokenizer(''))->tokens();
        $this->assertTokens($tokens, []);
    }

    public function testOneDigit(): void
    {
        $tokens= (new Tokenizer('1'))->tokens();
        $this->assertTokens($tokens, [
            [
                'type' => Token::TYPE_INTEGER,
                'value' => 1,
            ],
        ]);
    }

    public function testDigits(): void
    {
        $tokens= (new Tokenizer('12'))->tokens();
        $this->assertTokens($tokens, [
            [
                'type' => Token::TYPE_INTEGER,
                'value' => 12,
            ],
        ]);
    }

    public function testIntegerPlusInteger(): void
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
            assert(array_key_exists($index, $expectedTokensData));
            $expectedTokenData = $expectedTokensData[$index];
            assert($token->type() === $expectedTokenData['type']);
            assert($token->value() === $expectedTokenData['value']);
            $index++;
        }
        assert($index === count($expectedTokensData));
    }
}
