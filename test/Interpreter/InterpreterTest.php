<?php

namespace App\Test\Interpreter;

use App\Interpreter\Interpreter;
use App\Parser\Node\IntegerLiteral;
use App\Test\Test;
use App\Tokenizer\Token;

/**
 * Class InterpreterTest
 */
class InterpreterTest extends Test
{
    public function testIntegerLiteral(): void
    {
        $interpreter = new Interpreter();
        $tree = new IntegerLiteral(new Token(Token::TYPE_INTEGER, 1));
        ob_start();
        $interpreter->interpret($tree);
        $content = ob_get_clean();
        $this->assertEquals($content, '1');
    }
}
