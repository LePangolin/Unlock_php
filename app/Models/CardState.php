<?php

namespace App\Models;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use App\Helper\Enum;


#[Entity, Table(name: 'CardStates')]
final class CardState
{

    #[Id, Column(type: 'integer', nullable: false)]
    private int $idGame;

    #[Id, Column(type: 'string',  nullable: false)]
    private string $idCard;

    #[Id, Column(type: 'integer', nullable: false)]
    private int $idState;

    #[Id, Column(type: 'string',  nullable: false)]
    private string $idDeck;

    public function __construct(int $idGame, string $idCard, int $idState, string $idDeck)
    {
        $this->idGame = $idGame;
        $this->idCard = $idCard;
        $this->idState = $idState;
        $this->idDeck = $idDeck;
    }


    public function getIdGame(): int
    {
        return $this->idGame;
    }

    public function getIdCard(): string
    {
        return $this->idCard;
    }

    public function getIdState(): int
    {
        return $this->idState;
    }

    public function getIdDeck(): string
    {
        return $this->idDeck;
    }
}
