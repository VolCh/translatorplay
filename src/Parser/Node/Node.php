<?php

namespace App\Parser\Node;

/**
 * Class Node
 */
abstract class Node
{
    public function asArray(): array
    {
        return [
            'type' => $this->type(),
        ];
    }

    public function type(): string
    {
        $fqcnParts = explode('\\', static::class);
        return end($fqcnParts);
    }
}
