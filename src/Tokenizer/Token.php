<?php

namespace App\Tokenizer;

use InvalidArgumentException;

/**
 * Class Token
 * @package App\Tokenizer
 */
class Token
{
    public const TYPE_INTEGER = 'INTEGER';
    public const TYPE_PLUS = 'PLUS';

    private const TYPES = [self::TYPE_INTEGER, self::TYPE_PLUS];

    /** @var string */
    private $type;
    /** @var mixed */
    private $value;

    public function __construct(string $type, $value )
    {
        if (!in_array($type, self::TYPES, true)) {
            throw new InvalidArgumentException("Not supported type $type");
        }
        $this->type = $type;
        $this->value = $value;
    }

    public function type(): string
    {
        return $this->type;
    }

    /** @return mixed */
    public function value()
    {
        return $this->value;
    }
}
