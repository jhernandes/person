<?php

declare(strict_types=1);

namespace Jhernandes\Person;

use PHPUnit\Framework\TestCase;
use Jhernandes\Person\Domain\Person;

class PersonTest extends TestCase
{
    public function testCanBeCreatedWithValidNameAndCpf(): void
    {
        $this->assertInstanceOf(Person::class, new Person(
            'João Silva',
            '79999338801'
        ));
    }

    public function testCanBeCreatedAndReturnArray(): void
    {
        $person = new Person('José Freire', '79999338801');

        $this->assertEquals('José Freire', $person->jsonSerialize()['name']);
    }

    public function testCanBeCreatedAndAddedContacts(): void
    {
        $person = new Person('José Freire', '79999338801');
        $person->setEmail('jose@mail.me');
        $person->setMobilePhone('11990909090');
        $person->setHomePhone('1132321000');

        $this->assertNotEmpty($person->jsonSerialize()['email']);
        $this->assertNotEmpty($person->jsonSerialize()['contacts']['mobilePhone']);
        $this->assertNotEmpty($person->jsonSerialize()['contacts']['homePhone']);
    }

    public function testCannotBeCreatedWithoutValidCpf(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Person('José Freire', '');
    }

    public function testCannotBeCreatedWithoutValidName(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Person('Jones', '79999338801');
    }
}
