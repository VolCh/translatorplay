<?php

namespace App\Interpreter;

use App\Parser\Node\BinaryOperator;
use App\Parser\Node\Constant;
use App\Parser\Node\IntegerLiteral;
use App\Parser\Node\Node;
use DomainException;
use Interpreter\Scope;
use Interpreter\Symbol;

/**
 * Class Interpreter
 */
class Interpreter
{
    /** @var Scope */
    private $builtinScope;

    public function __construct()
    {
        $builtInScope = new Scope('BUILTIN', 0, null);
        $builtInScope->addSymbolValue('PI', Symbol::TYPE_CONSTANT, M_PI);
        $builtInScope->addSymbolValue('E', Symbol::TYPE_CONSTANT, M_E);
        $this->builtinScope = $builtInScope;
    }

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

    private function visitConstant(Constant $node) {
        if (!$this->builtinScope->isSymbolExists($node->value(), Symbol::TYPE_CONSTANT)) {
            throw new DomainException("Unknown constant {$node->value()}");
        }
        return $this->builtinScope->getSymbolValue($node->value(), Symbol::TYPE_CONSTANT);
    }
}
