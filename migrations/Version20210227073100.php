<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210227073100 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cars (id INT AUTO_INCREMENT NOT NULL, model_id INT DEFAULT NULL, active TINYINT(1) NOT NULL, year INT NOT NULL, km INT NOT NULL, short_description VARCHAR(80) NOT NULL, long_description VARCHAR(255) NOT NULL, price INT NOT NULL, main_image VARCHAR(255) NOT NULL, second_image VARCHAR(255) DEFAULT NULL, third_image VARCHAR(255) DEFAULT NULL, fourth_image VARCHAR(255) DEFAULT NULL, fifth_image VARCHAR(255) DEFAULT NULL, INDEX IDX_95C71D147975B7E7 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D147975B7E7 FOREIGN KEY (model_id) REFERENCES models (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cars');
    }
}
