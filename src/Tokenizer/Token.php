<?php

namespace App\Tokenizer;

use InvalidArgumentException;
use ReflectionClass;

/**
 * Class Token
 */
class Token
{
    public const TYPE_INTEGER = 'INTEGER';
    public const TYPE_MULTI = 'MULTI';
    public const TYPE_DIV = 'DIV';
    public const TYPE_PLUS = 'PLUS';
    public const TYPE_MINUS = 'MINUS';

    /** @var string */
    private $type;
    /** @var mixed */
    private $value;

    public function __construct(string $type, $value)
    {
        if (!in_array($type, self::types(), true)) {
            throw new InvalidArgumentException("Unknown type '$type'");
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

    /** @return string[] */
    private static function types(): array
    {
        static $types;

        if (empty($types)) {
            $types = (new ReflectionClass(self::class))->getConstants();
        }

        return $types;
    }
}
