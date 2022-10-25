<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use App\Helper\Enum;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221025062731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO States (name) VALUES (\''.ENUM::DISCARD.'\')');
        $this->addSql('INSERT INTO States (name) VALUES (\''.ENUM::DRAW.'\')');
        $this->addSql('INSERT INTO States (name) VALUES (\''.ENUM::PLAY.'\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
