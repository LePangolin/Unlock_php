<?php

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
final class Version202210111135 extends AbstractMigration
{
    private function addCard (&$array, $deckId, $idCard){
        array_push($array, ['id' => $idCard,'deckId' => $deckId, 'pathToRecto' => 'img/recto/' . $deckId . '/' . $idCard . '.png', 'pathToVerso' => 'img/verso/' . $deckId . '/' . $idCard . '.png']);
        return $array;
    }

    public function getDescription(): string
    {
        return 'Creation de la table \'cards\' et insertions des cartes';
    }

    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mariadb', 'Migration can only be executed safely on \'mariadb\'.');
        $this->addSql('CREATE TABLE cards (id STRING NOT NULL, deckId STRING NOT NULL, pathToRecto STRING NOT NULL, pathToVerso STRING NOT NULL, PRIMARY KEY(id, deckId))');

        $cards = [];

        /* Deck Tuto */
        $cards = $this->addCard($cards, 'tuto', '11');
        $cards = $this->addCard($cards, 'tuto', '16');
        $cards = $this->addCard($cards, 'tuto', '21');
        $cards = $this->addCard($cards, 'tuto', '25');
        $cards = $this->addCard($cards, 'tuto', '35');
        $cards = $this->addCard($cards, 'tuto', '42');
        $cards = $this->addCard($cards, 'tuto', '46');
        $cards = $this->addCard($cards, 'tuto', '48');
        $cards = $this->addCard($cards, 'tuto', '69');
        $cards = $this->addCard($cards, 'tuto', 'Main');
        /* Deck EP5 */
        $cards = $this->addCard($cards, 'ep5', '6');
        $cards = $this->addCard($cards, 'ep5', '8');
        $cards = $this->addCard($cards, 'ep5', '9');
        $cards = $this->addCard($cards, 'ep5', '15');
        $cards = $this->addCard($cards, 'ep5', '20');
        $cards = $this->addCard($cards, 'ep5', '22');
        $cards = $this->addCard($cards, 'ep5', '23');
        $cards = $this->addCard($cards, 'ep5', '24');
        $cards = $this->addCard($cards, 'ep5', '28');
        $cards = $this->addCard($cards, 'ep5', '30');
        $cards = $this->addCard($cards, 'ep5', '37');
        $cards = $this->addCard($cards, 'ep5', '39');
        $cards = $this->addCard($cards, 'ep5', '42');
        $cards = $this->addCard($cards, 'ep5', '55');
        $cards = $this->addCard($cards, 'ep5', '60');
        $cards = $this->addCard($cards, 'ep5', '66');
        $cards = $this->addCard($cards, 'ep5', '85');
        $cards = $this->addCard($cards, 'ep5', '88');
        $cards = $this->addCard($cards, 'ep5', '91');
        $cards = $this->addCard($cards, 'ep5', 'A');
        $cards = $this->addCard($cards, 'ep5', 'B');
        $cards = $this->addCard($cards, 'ep5', 'H');
        $cards = $this->addCard($cards, 'ep5', 'Main');
        $cards = $this->addCard($cards, 'ep5', 'R');
        
        foreach ($cards as $card) {
            $this->addSql('INSERT INTO cards (id, deckId, pathToRecto, pathToVerso) VALUES (?, ?, ?, ?)', [$card['id'], $card['deckId'], $card['pathToRecto'], $card['pathToVerso']]);
        }
    }

    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mariadb', 'Migration can only be executed safely on \'mariadb\'.');
        $this->addSql('DELETE FROM cards');
        $this->addSql('DROP TABLE cards');
    }
}

