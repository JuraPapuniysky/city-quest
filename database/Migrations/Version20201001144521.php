<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201001144521 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cities (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, is_deleted TINYINT(1) DEFAULT \'0\' NOT NULL, country_uuid VARCHAR(255) NOT NULL, name LONGTEXT NOT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_D95DB16BD17F50A6 (uuid), INDEX cities_uuid (uuid, country_uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE countries (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, name LONGTEXT NOT NULL, iso_code LONGTEXT NOT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_5D66EBADD17F50A6 (uuid), INDEX uuid (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quest_questions (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, quest_uuid VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, answer VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2C81590DD17F50A6 (uuid), INDEX uuid (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quests (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME DEFAULT NULL, country_uuid VARCHAR(255) NOT NULL, city_uuid VARCHAR(255) NOT NULL, name LONGTEXT NOT NULL, description LONGTEXT NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_989E5D34D17F50A6 (uuid), INDEX uuid (uuid, country_uuid, city_uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cities');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE quest_questions');
        $this->addSql('DROP TABLE quests');
    }
}
