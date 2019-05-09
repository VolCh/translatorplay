<?php

namespace App\Parser\Node;

use App\Tokenizer\Token;

/**
 * Class BinaryOperator
 */
class BinaryOperator extends Node
{
    /** @var Node */
    private $left;
    /** @var Token */
    private $operator;
    /** @var Node */
    private $right;

    public function __construct(Node $left, Token $operator, Node $right)
    {
        $this->left = $left;
        $this->operator = $operator;
        $this->right = $right;
    }

    public function left(): Node
    {
        return $this->left;
    }

    public function right(): Node
    {
        return $this->right;
    }

    public function operator(): Token
    {
        return $this->operator;
    }

    public function asArray(): array
    {
        return parent::asArray() + [
            'operator' => $this->operator->value(),
            'left' => $this->left->asArray(),
            'right' => $this->right->asArray(),
        ];
    }
}
