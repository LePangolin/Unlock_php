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

    #[Id, Column(type: 'integer')]
    private int $playerId;

    #[Id, Column(type: 'integer')]
    private string $deckId;

    public function __construct(int $playerId, string $deckId)
    {
        $this->playerId = $playerId;
        $this->deckId = $deckId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPlayerId(): int
    {
        return $this->playerId;
    }

    public function getDeckId(): string
    {
        return $this->deckId;
    }
    
}
