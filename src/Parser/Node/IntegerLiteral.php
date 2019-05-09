<?php

namespace App\Parser\Node;

use App\Tokenizer\Token;

/**
 * Class IntegerLiteral
 */
class IntegerLiteral extends Node
{
    /** @var Token */
    private $token;
    /** @var int  */
    private $value;
    public function __construct(Token $token)
    {
        $this->token = $token;
        $this->value = $token->value();
    }

    public function value(): int
    {
        return $this->value;
    }

    public function asArray(): array
    {
        return parent::asArray() + ['value' => $this->value];
    }
}
