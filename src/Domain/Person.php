<?php

declare(strict_types=1);

namespace Jhernandes\Person\Domain;

use Jhernandes\Person\Domain\Cpf;
use Jhernandes\Person\Domain\Name;
use Jhernandes\Contacts\Domain\Email;
use Jhernandes\Contacts\Domain\Phone;
use Jhernandes\BrazilianAddress\Domain\Address;

class Person implements \JsonSerializable
{
    private Name $name;
    private Cpf $cpf;
    private Date $birthdate;
    private Email $email;
    private Phone $mobilePhone;
    private Phone $homePhone;
    private Address $address;

    public function __construct(string $name, string $cpf)
    {
        $this->name = Name::fromString($name);
        $this->cpf = Cpf::fromString($cpf);
    }

    public static function fromString(string $name, string $cpf): self
    {
        return new self($name, $cpf);
    }

    public function setBirthdate(string $birthdate): void
    {
        $this->birthdate = Date::fromString($birthdate);
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

    public function setAddress(string $address): void
    {
        $this->address = Address::fromString($address);
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => (string) $this->name,
            'cpf' => (string) $this->cpf,
            'birthdate' => (string) (isset($this->birthdate) ? $this->birthdate : ''),
            'email' => (string) (isset($this->email) ? $this->email : ''),
            'contacts' => [
                'mobilePhone' => (string) (isset($this->mobilePhone) ? $this->mobilePhone : ''),
                'homePhone' => (string) (isset($this->homePhone) ? $this->homePhone : ''),
            ],
            'address' => isset($this->address) ? $this->address->jsonSerialize() : [],
        ];
    }
}
