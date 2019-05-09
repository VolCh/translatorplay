<?php

namespace App\Test\Interpreter;

use App\Interpreter\Interpreter;
use App\Parser\Node\IntegerLiteral;
use App\Tokenizer\Token;

/**
 * Class InterpreterTest
 */
class InterpreterTest
{
    public function testInteger(): void
    {
        $interpreter = new Interpreter();
        ob_start();
        $interpreter->interpret(new IntegerLiteral(new Token(Token::TYPE_INTEGER, 1)));
        $content = ob_get_clean();
        assert($content === '1');
    }
}
