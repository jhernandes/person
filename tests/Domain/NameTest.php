<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\Person\Domain\Name;

class NameTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertEquals(
            'João Mâck Sílva',
            Name::fromString('João Mâck Sílva')
        );
    }

    public function testCannotBeCreateWithOnlyFirstName(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Name::fromString('João');
    }

    public function testCannotBeCreateWithInvalidCharacters(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Name::fromString('Joa1o-+Teste/][');
    }
}
