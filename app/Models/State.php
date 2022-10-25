<?php

namespace App\Models;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use App\Helper\Enum;

#[Entity, Table(name: 'States')]
final class State
{
    #[ID, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $idState;

    #[Column(type: 'string', length: 50, nullable: false)]
    private Enum $name;

    public function __construct(Enum $name)
    {
        $this->name = $name;
    }

    public function getIdState(): int
    {
        return $this->idState;
    }

    public function getName(): Enum
    {
        return $this->name;
    }

}
