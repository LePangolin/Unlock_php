<?php

namespace App\Models;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'Cards')]
final class Card
{
    #[Id, Column(type: 'String'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Id, Column(type: 'String')]
    private string $deckId;

    #[Column(type: 'String')]
    private string $pathToRecto;

    #[Column(type: 'String')]
    private string $pathToVerso;

    public function __construct(string $deckId, string $pathToRecto, string $pathToVerso)
    {
        $this->deckId = $deckId;
        $this->pathToRecto = $pathToRecto;
        $this->pathToVerso = $pathToVerso;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDeckId(): string
    {
        return $this->deckId;
    }

    public function getPathToRecto(): string
    {
        return $this->pathToRecto;
    }

    public function getPathToVerso(): string
    {
        return $this->pathToVerso;
    }

}