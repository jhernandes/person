<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\Contacts\Domain\Email;
use Jhernandes\Contacts\Domain\Phone;
use Jhernandes\Person\Domain\Contacts;

class ContactsTest extends TestCase
{
    public function testCanBeCreatedWithEmptyItens(): void
    {
        $contacts = new Contacts();

        $this->assertInstanceOf(Contacts::class, $contacts);
    }

    public function testeCanBeCreatedFromAList(): void
    {
        $contacts = Contacts::fromList([
            Phone::fromString('11990001000'),
            Phone::fromString('11990001001'),
        ]);

        $this->assertCount(2, $contacts->all());
    }

    public function testCannotAddInvalidContact(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        $contacts = Contacts::fromList([]);
        $contacts->add('invalid contact');
    }

    public function testCanBeTransformedInArray(): void
    {
        $this->assertEquals([
            '(11) 99000-1000',
            '(11) 99000-1001'
        ], Contacts::fromList([
            Phone::fromString('11990001000'),
            Phone::fromString('11990001001'),
        ])->jsonSerialize());
    }
}
