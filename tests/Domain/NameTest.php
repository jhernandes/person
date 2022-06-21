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

    public function testCannotBeCreateWithInvalidCharacters(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        Name::fromString('Joa1o-+Teste/][');
    }

    public function testCanAccessFirstAndLastnames(): void
    {
        $name = Name::fromString('Josias Carlos Magno');

        $this->assertSame(
            ['Josias', 'Carlos Magno'],
            [$name->firstname(), $name->lastname()]
        );
    }

    public function testLastnameIsEmptyIfNotInitialized(): void
    {
        $name = Name::fromString('Josias');

        $this->assertSame(
            ['Josias', ''],
            [$name->firstname(), $name->lastname()]
        );
    }
}
