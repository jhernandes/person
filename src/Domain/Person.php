<?php

declare(strict_types=1);

namespace Jhernandes\Person\Domain;

use Jhernandes\Person\Domain\Name;
use Jhernandes\Contacts\Domain\Email;
use Jhernandes\Contacts\Domain\Phone;

class Person implements \JsonSerializable
{
    private Name $name;
    private CPF $cpf;
    private Email $email;
    private Phone $mobilePhone;
    private Phone $homePhone;
    // private Address $address;

    public function __construct(string $name, string $cpf)
    {
        $this->name = Name::fromString($name);
        $this->cpf = CPF::fromString($cpf);
    }

    public function setEmail(string $email): void
    {
        $this->email = Email::fromString($email);
    }

    public function setMobilePhone(string $mobilePhone): void
    {
        $this->mobilePhone = Phone::fromString($mobilePhone);
    }

    public function setHomePhone(string $homePhone): void
    {
        $this->homePhone = Phone::fromString($homePhone);
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => (string) $this->name,
            'cpf' => (string) $this->cpf,
            'email' => (string) isset($this->email) ?: '',
            'contacts' => [
                'mobilePhone' => (string) isset($this->mobilePhone) ?: '',
                'homePhone' => (string) isset($this->homePhone) ?: '',
            ],
            // 'address' => [
            //     'street' => $this->address->street ?? '',
            // ]
        ];
    }
}
