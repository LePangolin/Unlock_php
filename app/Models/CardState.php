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

    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $idGame;
    
    #[Column(type: 'integer',  nullable: false)]
    private string $idCard;

    #[Column(type: 'string', nullable: false)]
    private Enum $state;

    public function __construct(int $idGame, string $idCard, Enum $state)
    {
        $this->idGame = $idGame;
        $this->idCard = $idCard;
        $this->state = $state;
    }

    public function getIdGame(): int
    {
        return $this->idGame;
    }

    public function getIdCard(): string
    {
        return $this->idCard;
    }

    public function getState(): Enum
    {
        return $this->state;
    }

}
