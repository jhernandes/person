<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\Person\Domain\Date;
use Jhernandes\Person\Domain\Name;

class DateTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertSame(
            '1988-10-03',
            (string) Date::fromString('1988-10-03')
        );
    }

    public function testCannotBeCreatedFromInvalidFormatString(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        Date::fromString('1988-10-03', 'ABC');
    }
}
