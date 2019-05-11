<?php

namespace App\Interpreter;

use App\Parser\Node\BinaryOperator;
use App\Parser\Node\IntegerLiteral;
use App\Parser\Node\Node;
use DomainException;

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

    private function visitBinaryOperator(BinaryOperator $node)
    {
        $leftValue = $this->visit($node->left());
        $rightValue = $this->visit($node->right());
        if ($node->operator()->value() === '+') {
            return $leftValue + $rightValue;
        }
        if ($node->operator()->value() === '-') {
            return $leftValue - $rightValue;
        }
        if ($node->operator()->value() === '*') {
            return $leftValue * $rightValue;
        }
        if ($node->operator()->value() === '/') {
            return intdiv($leftValue, $rightValue);
        }
        throw new DomainException("Unknown operator {$node->operator()->value()}");
    }
}
