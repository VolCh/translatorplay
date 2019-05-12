<?php

namespace App\Tokenizer;

use Generator;
use InvalidArgumentException;

/**
 * Class Tokenizer
 */
class Tokenizer
{
    /** @var string */
    private $input;

    public function __construct(string $input)
    {
        $this->input = $input;
        $this->pos = 0;
    }

    /** @return Generator|Token[] */
    public function tokens(): Generator
    {
        while ($this->currentChar() !== null) {
            $char = $this->currentChar();
            if (ctype_alpha($char)) {
                yield new Token(Token::TYPE_IDENTIFIER, $this->identifier());
            } elseif (ctype_digit($char)) {
                yield new Token(Token::TYPE_INTEGER, $this->integer());
            } elseif ($char === '+') {
                $this->advance();
                yield new Token(Token::TYPE_PLUS, '+');
            } elseif ($char === '-') {
                $this->advance();
                yield new Token(Token::TYPE_MINUS, '-');
            } elseif ($char === '*') {
                $this->advance();
                yield new Token(Token::TYPE_MULTI, '*');
            } elseif ($char === '/') {
                $this->advance();
                yield new Token(Token::TYPE_DIV, '/');
            } elseif ($char === '(') {
                $this->advance();
                yield new Token(Token::TYPE_LEFT_PARENTHESIS, '(');
            } elseif ($char === ')') {
                $this->advance();
                yield new Token(Token::TYPE_RIGHT_PARENTHESIS, ')');
            } else {
                throw new InvalidArgumentException("Unexpected symbol '{$char}' at a position {$this->pos}");
            }
        }

    }

    private function currentChar(): ?string
    {
        return $this->input[$this->pos] ?? null;
    }

    private function advance(): void
    {
        $this->pos++;
    }

    private function integer(): int
    {
        $chars = '';
        while (ctype_digit($this->currentChar())) {
            $chars .= $this->currentChar();
            $this->advance();
        }
        return (int)$chars;
    }

    private function identifier(): string
    {
        $chars = '';
        while (ctype_alnum($this->currentChar())) {
            $chars .= $this->currentChar();
            $this->advance();
        }
        return $chars;
    }
}
