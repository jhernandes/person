<?php

declare(strict_types=1);

namespace Jhernandes\Person\Domain;

class Name
{
    private string $firstname;
    private string $lastname;

    public function __construct(string $firstname, string $lastname)
    {
        $this->ensureIsValidName($firstname);
        $this->ensureIsValidName($lastname);

        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public static function fromString(string $name): self
    {
        $name = explode(' ', $name);
        $firstname = array_shift($name);
        $lastname = implode(' ', $name);

        return new self($firstname, $lastname);
    }

    public function __toString(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function ensureIsValidName(string $name): void
    {
        foreach (explode(' ', $name) as $singlename) {
            if (!preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿ]+$/', $singlename)) {
                throw new \InvalidArgumentException(
                    sprintf('%s is not a valid name', $singlename)
                );
            }
        }
    }
}
