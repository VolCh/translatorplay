<?php

namespace App\Test\Parser;

use App\Parser\Parser;
use App\Tokenizer\Token;

/**
 * Class ParserTest
 * @package App\Test\Parser
 */
class ParserTest
{
    public function parseDigit(): void
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
}
