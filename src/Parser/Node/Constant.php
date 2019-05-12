<?php

namespace App\Parser\Node;

use App\Tokenizer\Token;

/**
 * Class Constant
 */
class Constant extends Node
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

    public function value(): string
    {
        return $this->value;
    }

    public function asArray(): array
    {
        return parent::asArray() + ['value' => $this->value];
    }
}
