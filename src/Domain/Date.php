<?php

declare(strict_types=1);

namespace Jhernandes\Person\Domain;

use DateTimeImmutable;
use DateTimeInterface;

class Date
{
    private DateTimeImmutable $date;

    public function __construct(DateTimeInterface $date)
    {
        $this->date = DateTimeImmutable::createFromFormat('Y-m-d', $date->format('Y-m-d'));
    }

    public static function fromString(string $date, string $format = 'Y-m-d'): self
    {
        $datetime = DateTimeImmutable::createFromFormat($format, $date);

        if (!($datetime !== false && !array_sum($datetime::getLastErrors()))) {
            throw new \UnexpectedValueException(
                sprintf('%s date is not valid date in format %s', $date, $format)
            );
        }

        return new self($datetime);
    }

    public function __toString(): string
    {
        return $this->date->format('Y-m-d');
    }
}
