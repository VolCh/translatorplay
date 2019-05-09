<?php

namespace App\Interpreter;

use App\Parser\Node\IntegerLiteral;
use App\Parser\Node\Node;

/**
 * Class Interpreter
 */
class Interpreter
{
    public function interpret(Node $node): void
    {
        if ($node instanceof IntegerLiteral) {
            echo $node->value();
        }
    }
}
