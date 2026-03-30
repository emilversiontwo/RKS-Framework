<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class ExampleTest extends TestCase
{
    public function testExampleFirst(): void
    {
        $this->assertSame("string", "string");
    }

    public function testExampleSecond(): void
    {
        $this->assertSame(true, true);
    }
}