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
        $result = $this->visit($node);
        echo $result;
    }

    private function visit(Node $node)
    {
        $visitMethodName = "visit{$node->type()}";
        return $this->$visitMethodName($node);

    }

    private function visitIntegerLiteral(IntegerLiteral $node)
    {
        return $node->value();
    }
}
