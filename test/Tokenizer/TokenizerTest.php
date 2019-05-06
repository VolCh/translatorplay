<?php

namespace App\Test\Tokenizer;

use App\Tokenizer\Token;
use App\Tokenizer\Tokenizer;

/**
 * Class TokenizerTest
 */
class TokenizerTest
{
    public function testEmpty(): void
    {
        $tokenGenerator = Tokenizer::createGenerator('');
        /** @var Token $token */
        $token = $tokenGenerator->current();
        assert($token->type() === 'EOF');
        assert($token->value() === null);
    }
}
