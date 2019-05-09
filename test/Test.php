<?php

namespace App\Test;

use Error;
use ReflectionClass;
use ReflectionMethod;

/**
 * Class Test
 */
abstract class Test
{
    public function runAll(): void
    {
        $class = new ReflectionClass($this);
        $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        $testMethods = array_filter($methods, function (ReflectionMethod $method) {
            return strpos($method->name, 'test') === 0;
        });
        foreach ($testMethods as $method) {
            $method->invoke($this);
        }
    }

    public function assertEquals($current, $expected): void
    {
        assert($current === $expected, new Error());
    }
}
