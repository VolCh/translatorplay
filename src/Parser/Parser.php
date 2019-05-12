<?php

namespace App\Parser;

use App\Parser\Node\BinaryOperator;
use App\Parser\Node\Constant;
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
     * expression : term ((PLUS | MINUS) term)*
     */
    private function expression(): Node
    {
        $node = $this->term();
        $token = $this->currentToken();
        while ($token !== null) {
            if (in_array($token->type(), [Token::TYPE_PLUS, Token::TYPE_MINUS], true)) {
                $this->takeToken($token->type());
                $node = new BinaryOperator($node, $token, $this->term());
                $token = $this->currentToken();
            } else {
                break;
            }
        }

        return $node;
    }

    /**
     * Term is a member of an addition or a subtraction
     *
     * term : factor ((MULTI | DIV)) factor)*
     */
    private function term(): Node
    {
        $node = $this->factor();
        $token = $this->currentToken();
        while ($token !== null) {
            if (in_array($token->type(), [Token::TYPE_MULTI, Token::TYPE_DIV], true)) {
                $this->takeToken($token->type());
                $node = new BinaryOperator($node, $token, $this->factor());
                $token = $this->currentToken();
            } else {
                break;
            }
        }

        return $node;
    }

    /**
     * Factor is a member of a multiplication or a division
     *
     * factor : integerLiteral | LEFT_PARENTHESIS expression RIGHT_PARENTHESIS
     */
    private function factor(): Node
    {
        $token = $this->currentToken();
        if ($token === null) {
            throw new DomainException('Unexpected end, an expression is expected');
        }
        if ($token->type() === Token::TYPE_INTEGER) {
            return $this->integerLiteral();
        }
        if ($token->type() === Token::TYPE_IDENTIFIER) {
            return $this->constant();
        }
        if ($token->type() === Token::TYPE_LEFT_PARENTHESIS) {
            $this->takeToken(Token::TYPE_LEFT_PARENTHESIS);
            $node = $this->expression();
            $this->takeToken(TOKEN::TYPE_RIGHT_PARENTHESIS);
            return $node;
        }
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

    /**
     * constant : [a-zA-z][0-9a-zA-z]*
     */
    private function constant(): Constant
    {
        $token = $this->currentToken();
        $this->takeToken(Token::TYPE_IDENTIFIER);

        return new Constant($token);
    }

    /**
     * expression : term ((PLUS | MINUS) term)*
     * term : factor ((MULTI | DIV)) factor)*
     * factor : integerLiteral | LEFT_PARENTHESIS expression RIGHT_PARENTHESIS
     * integerLiteral : [0-9]+
     * PLUS : +
     * MINUS : -
     * MULTI : *
     * DIV : /
     * LEFT_PARENTHESIS : (
     * RIGHT_PARENTHESIS : )
     */
    public function parse(): ?Node
    {
        $token = $this->currentToken();
        if ($token === null) {
            return null;
        }
        switch ($token->type()) {
            case Token::TYPE_IDENTIFIER;
            case Token::TYPE_INTEGER;
                $node = $this->expression();
                break;
            default:
                throw new DomainException("Unsupported token type {$token->type()}");
        }
        return $node;
    }
}
