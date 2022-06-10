<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\Person\Domain\CPF;
use Jhernandes\Person\Domain\Name;

class CPFTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertEquals(
            '79999338801',
            CPF::fromString('799.993.388-01')
        );
    }

    public function testCanBeFormatted(): void
    {
        $this->assertEquals(
            '799.993.388-01',
            CPF::fromString('79999338801')->formatted()
        );
    }

    public function testCannotBeCreateFromInvalidCpf(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Name::fromString('111.111.111-11');
    }

    public function testCannotBeCreateWithInvalidCpfString(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Name::fromString('asdqwe123asd12');
    }
}
