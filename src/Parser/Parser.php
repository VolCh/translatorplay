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
    private $tokens;

    public function __construct(Generator $tokenizer)
    {
        $this->tokens = $tokenizer;
    }

    private function currentToken(): ?Token
    {
        return $this->tokens->current();
    }

    private function takeToken(string $tokenType): void
    {
        $token = $this->currentToken();
        if ($token === null) {
            throw new DomainException("Unexpected end, $tokenType is expected");
        }
        if ($token->type() !== $tokenType) {
            throw new DomainException("Can't take {$tokenType}, {$token->type()} is current one");
        }
        $this->tokens->next();
    }


    /**
     * expression : integerLiteral (PLUS integerLiteral)*
     */
    private function expression(): Node
    {
        $node = $this->integerLiteral();
        $token = $this->currentToken();
        while ($token !== null && $token->type() === Token::TYPE_PLUS) {
            $this->takeToken(Token::TYPE_PLUS);
            $node = new BinaryOperator($node, $token, $this->integerLiteral());
            $token = $this->currentToken();
        }

        return $node;
    }

    /**
     * integerLiteral : [0-9]+
     */
    private function integerLiteral(): IntegerLiteral
    {
        $token = $this->currentToken();
        $this->takeToken(Token::TYPE_INTEGER);

        return new IntegerLiteral($token);
    }

    public function parse(): ?Node
    {
        $token = $this->currentToken();
        if ($token === null) {
            return null;
        }
        switch ($token->type()) {
            case Token::TYPE_INTEGER;
                $node = $this->expression();
                break;
            default:
                throw new DomainException("Unsupported token type {$token->type()}");
        }
        return $node;
    }
}
