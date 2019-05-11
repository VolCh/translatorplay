<?php

namespace App\Test\Interpreter;

use App\Interpreter\Interpreter;
use App\Parser\Node\BinaryOperator;
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

    public function testPlus(): void
    {
        $interpreter = new Interpreter();
        $tree = new BinaryOperator(
            new IntegerLiteral(new Token(Token::TYPE_INTEGER, 1)),
            new Token(Token::TYPE_PLUS, '+'),
            new IntegerLiteral(new Token(Token::TYPE_INTEGER, 2))
        );
        ob_start();
        $interpreter->interpret($tree);
        $content = ob_get_clean();
        $this->assertEquals($content, '3');
    }

    public function testMinus(): void
    {
        $interpreter = new Interpreter();
        $tree = new BinaryOperator(
            new IntegerLiteral(new Token(Token::TYPE_INTEGER, 1)),
            new Token(Token::TYPE_MINUS, '-'),
            new IntegerLiteral(new Token(Token::TYPE_INTEGER, 2))
        );
        ob_start();
        $interpreter->interpret($tree);
        $content = ob_get_clean();
        $this->assertEquals($content, '-1');
    }
}
