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

    /* variables constantes pour les cartes récurrentes et leurs chemins images */
    const MAINCARD = "Main";
    const DISCARD_DEFAULT = "Discard";
    const IMG_PATH = "img/cards/";

    #[Id, Column(type: 'string'), JoinColumn(name: '', referencedColumnName: 'idCard')]
    private string $id;

    #[Id, Column(type: 'string')]
    private string $deckId;

    public function __construct(string $deckId)
    {
        $this->deckId = $deckId;
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
        return Card::IMG_PATH . "recto/" . $this->deckId . "/" . $this->id . ".png";
    }

    public function getPathToVerso(): string
    {
        return Card::IMG_PATH . "verso/" . $this->deckId . "/" . $this->id . ".png";
    }
}
