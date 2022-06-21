<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\Person\Domain\Cpf;

class CpfTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertSame(
            '799.993.388-01',
            (string) Cpf::fromString('799.993.388-01')
        );
    }

    public function testCannotBeCreateFromInvalidCpf(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        Cpf::fromString('111.111.111-11');
    }

    public function testCannotBeCreateWithInvalidCpfString(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        Cpf::fromString('asdqwe123asd12');
    }
}
