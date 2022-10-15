<?php

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version202210111135 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $cards = [];
        array_push($cards, ['id' => '1', 'deckId' => "ep5", 'pathToRecto' => 'img/recto/ep5/1.png', 'pathToVerso' => 'img/verso/ep5/1.png']);
    }
}