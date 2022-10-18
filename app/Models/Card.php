<?php

namespace App\Models;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'Cards')]
final class Card
{

    #[Id, Column(type: 'string'), JoinColumn(name: '', referencedColumnName: 'idCard')]
    private string $id;

    #[Id, Column(type: 'string')]
    private string $deckId;

    #[Column(type: 'string')]
    private string $pathToRecto;

    #[Column(type: 'string')]
    private string $pathToVerso;

    public function __construct(string $deckId, string $pathToRecto, string $pathToVerso)
    {
        $this->deckId = $deckId;
        $this->pathToRecto = $pathToRecto;
        $this->pathToVerso = $pathToVerso;
    }

    public function getId(): string
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