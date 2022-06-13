<?php

declare(strict_types=1);

namespace Jhernandes\Person\Domain;

class Cpf
{
    private string $cpf;

    public function __construct(string $cpf)
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        $this->ensureIsValidCpf($cpf);

        $this->cpf = $cpf;
    }

    public static function fromString(string $cpf): self
    {
        return new self($cpf);
    }

    public function __toString(): string
    {
        return $this->formatted();
    }

    public function formatted(): string
    {
        return sprintf(
            '%s.%s.%s-%s',
            substr($this->cpf, 0, 3),
            substr($this->cpf, 3, 3),
            substr($this->cpf, 6, 3),
            substr($this->cpf, 9, 2)
        );
    }

    private function ensureIsValidCpf(string $cpf): void
    {
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            throw new \InvalidArgumentException(
                sprintf('%s is not a valid CPF', $cpf)
            );
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            throw new \InvalidArgumentException(
                sprintf('%s is not a valid CPF', $cpf)
            );
        }

        $cpfAsArray = array_map(fn ($digit) => (int) $digit, str_split($cpf));

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpfAsArray[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpfAsArray[$c] !== $d) {
                throw new \InvalidArgumentException(
                    sprintf('%s is not a valid CPF', $cpf)
                );
            }
        }
    }
}
