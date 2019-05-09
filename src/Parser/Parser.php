<?php

namespace App\Parser;

use App\Parser\Node\BinaryOperator;
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

    private function take(string $tokenType): void
    {
        if ($this->currentToken() === null) {
            throw new DomainException("Unexpected end, $tokenType is expected");
        }
        if ($this->currentToken()->type() !== $tokenType) {
            throw new DomainException("Can't take {$tokenType}, {$this->currentToken()->type()} is current one");
        }
        $this->tokenStream->next();
    }


    /**
     * expression : integerLiteral
     */
    private function expression(): Node
    {
        $node = $this->integerLiteral();
        $token = $this->currentToken();
        if ($token !== null && $token->type() === Token::TYPE_PLUS) {
            $this->take(Token::TYPE_PLUS);
            $node = new BinaryOperator($node, $token, $this->integerLiteral());
        }

        return $node;
    }

    /**
     * integerLiteral : [0-9]+
     */
    private function integerLiteral(): IntegerLiteral
    {
        $token = $this->currentToken();
        $this->take(Token::TYPE_INTEGER);

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
