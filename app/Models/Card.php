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

    #[Id, Column(type: 'String'), GeneratedValue(strategy: 'AUTO')]
    private string $deckId;

    #[Column(type: 'String'), GeneratedValue(strategy: 'AUTO')]
    private string $pathToRecto;

    #[Column(type: 'String'), GeneratedValue(strategy: 'AUTO')]
    private string $pathToVerso;
}