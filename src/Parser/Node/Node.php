<?php

namespace App\Parser\Node;

/**
 * Class Node
 */
abstract class Node
{
    public function asArray(): array
    {
        $parts = explode('\\', static::class);
        $type = end($parts);
        return [
            'type' => $type,
        ];
    }
}
