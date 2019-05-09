<?php

namespace App\Parser;

use App\Parser\Node\IntegerLiteral;
use App\Parser\Node\Node;
use App\Tokenizer\Token;
use DomainException;
use Generator;

/**
 * Class Parser
 */
class Parser
{
    /** @var Generator|Token[] */
    private $tokenStream;

    public function __construct(Generator $tokenizer)
    {

        $this->tokenStream = $tokenizer;
    }

    private function currentToken(): ?Token
    {
        return $this->tokenStream->current();
    }


    /**
     * expression : integerLiteral
     */
    private function expression(): Node
    {
        return $this->integerLiteral();
    }

    /**
     * integerLiteral : [0-9]+
     */
    private function integerLiteral(): IntegerLiteral
    {
        $token = $this->currentToken();

        return new IntegerLiteral($token);
    }

    public function parse(): Node
    {
        $currentToken = $this->currentToken();
        $tokenType = $currentToken->type();
        switch ($tokenType) {
            case Token::TYPE_INTEGER;
                $node = $this->expression();
                break;
            default:
                throw new DomainException("Unsupported token type $tokenType");
        }
        return $node;
    }
}
