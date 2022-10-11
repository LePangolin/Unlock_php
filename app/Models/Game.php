<?php

namespace App\Models;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'Games')]
final class Game
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $playerId;

    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private string $deckId;
}
