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
        $this->ensureIsValidName($lastname, true);

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
        return "{$this->firstname()} {$this->lastname()}";
    }

    public function firstname(): string
    {
        return $this->firstname;
    }

    public function lastname(): string
    {
        return isset($this->lastname) ? $this->lastname : '';
    }

    private function ensureIsValidName(string $name, bool $canBeEmpty = false): void
    {
        foreach (explode(' ', $name) as $singlename) {
            if (empty($singlename) && $canBeEmpty) {
                continue;
            }

            if (!preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿ]+$/', $singlename)) {
                throw new \UnexpectedValueException(
                    sprintf('%s is not a valid name', $name)
                );
            }
        }
    }
}
