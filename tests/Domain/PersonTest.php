<?php

declare(strict_types=1);

namespace Jhernandes\Person;

use Jhernandes\BrazilianAddress\Domain\Address;
use PHPUnit\Framework\TestCase;
use Jhernandes\Person\Domain\Person;

class PersonTest extends TestCase
{
    public function testCanBeCreatedWithValidNameAndCpf(): void
    {
        $this->assertInstanceOf(Person::class, Person::fromString(
            'João Silva',
            '79999338801'
        ));
    }

    public function testCanBeCreatedAndReturnArray(): void
    {
        $person = Person::fromString('José Freire', '79999338801');

        $this->assertEquals('José Freire', $person->jsonSerialize()['name']);
    }

    public function testCanBeCreatedAndAddedContacts(): void
    {
        $person = Person::fromString('José Freire', '79999338801');
        $person->setEmail('jose@mail.me');
        $person->setMobilePhone('11990909090');
        $person->setHomePhone('1132321000');

        $this->assertSame('jose@mail.me', $person->jsonSerialize()['email']);
        $this->assertSame('(11) 99090-9090', $person->jsonSerialize()['contacts']['mobilePhone']);
        $this->assertSame('(11) 3232-1000', $person->jsonSerialize()['contacts']['homePhone']);
    }

    public function testCanBeCreatedAndAddedAddress(): void
    {
        $person = Person::fromString('José Freire', '79999338801');
        $person->setAddress('Rua Teste, 100, Bairro Teste,, Sao Paulo, SP, 01156060');

        $this->assertNotEmpty($person->jsonSerialize()['address']);
        $this->assertSame('Rua Teste', $person->jsonSerialize()['address']['street']);
        $this->assertSame('100', $person->jsonSerialize()['address']['number']);
        $this->assertSame('Bairro Teste', $person->jsonSerialize()['address']['district']);
        $this->assertSame('', $person->jsonSerialize()['address']['complement']);
        $this->assertSame('Sao Paulo', $person->jsonSerialize()['address']['city']);
        $this->assertSame('SP', $person->jsonSerialize()['address']['state']);
        $this->assertSame('01156-060', $person->jsonSerialize()['address']['cep']);
    }

    public function testCanBeCreatedAndAddedBirthdate(): void
    {
        $birthdate = '1988-10-03';
        $person = Person::fromString('José Freire', '79999338801');
        $person->setBirthdate($birthdate);

        $this->assertSame($birthdate, $person->jsonSerialize()['birthdate']);
    }

    public function testCannotBeCreatedWithoutValidCpf(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Person::fromString('José Freire', '');
    }

    public function testCannotBeCreatedWithoutValidName(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Person::fromString('Jones', '79999338801');
    }
}
