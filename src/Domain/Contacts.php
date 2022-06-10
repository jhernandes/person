<?php

declare(strict_types=1);

namespace Jhernandes\Person\Domain;

use Ds\Vector;
use Jhernandes\Contacts\Domain\Phone;

class Contacts implements \JsonSerializable
{
    private Vector $contacts;

    public function __construct(array $contacts = [])
    {
        $this->contacts = new Vector();

        foreach ($contacts as $contact) {
            $this->add($contact);
        }
    }

    public static function fromList(array $list): self
    {
        return new self($list);
    }

    public function add($contact): void
    {
        $this->ensureIsAValidContact($contact);
        $this->contacts->push($contact);
    }

    public function all(): array
    {
        return $this->contacts
            ->copy()
            ->toArray();
    }

    public function jsonSerialize(): array
    {
        return $this->contacts->map(fn (Phone $contact) => $contact->formatted())->toArray();
    }

    private function ensureIsAValidContact($contact)
    {
        if (!$contact instanceof Phone) {
            throw new \UnexpectedValueException(
                sprintf('%s is not a valid contact', $contact)
            );
        }
    }
}
