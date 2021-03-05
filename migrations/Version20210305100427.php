<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210305100427 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY cars_models');
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY cars_users');
        $this->addSql('ALTER TABLE cars CHANGE user_id user_id INT DEFAULT NULL, CHANGE model_id model_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D147975B7E7 FOREIGN KEY (model_id) REFERENCES models (id)');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D14A76ED395 FOREIGN KEY (user_id) REFERENCES users (user_id)');
        $this->addSql('ALTER TABLE favourites DROP FOREIGN KEY cars_car_saved');
        $this->addSql('ALTER TABLE favourites DROP FOREIGN KEY users_user_id');
        $this->addSql('ALTER TABLE favourites ADD CONSTRAINT FK_7F07C501C3C6F69F FOREIGN KEY (car_id) REFERENCES cars (car_id)');
        $this->addSql('ALTER TABLE favourites ADD CONSTRAINT FK_7F07C501A76ED395 FOREIGN KEY (user_id) REFERENCES users (user_id)');
        $this->addSql('ALTER TABLE models DROP FOREIGN KEY models_brands');
        $this->addSql('ALTER TABLE models CHANGE brand_id brand_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE models ADD CONSTRAINT FK_E4D6300944F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id)');
        $this->addSql('ALTER TABLE users CHANGE password password VARCHAR(255) NOT NULL, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D147975B7E7');
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D14A76ED395');
        $this->addSql('ALTER TABLE cars CHANGE model_id model_id INT NOT NULL, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT cars_models FOREIGN KEY (model_id) REFERENCES models (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT cars_users FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favourites DROP FOREIGN KEY FK_7F07C501C3C6F69F');
        $this->addSql('ALTER TABLE favourites DROP FOREIGN KEY FK_7F07C501A76ED395');
        $this->addSql('ALTER TABLE favourites ADD CONSTRAINT cars_car_saved FOREIGN KEY (car_id) REFERENCES cars (car_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favourites ADD CONSTRAINT users_user_id FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE models DROP FOREIGN KEY FK_E4D6300944F5D008');
        $this->addSql('ALTER TABLE models CHANGE brand_id brand_id INT NOT NULL');
        $this->addSql('ALTER TABLE models ADD CONSTRAINT models_brands FOREIGN KEY (brand_id) REFERENCES brands (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users CHANGE password password VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE roles roles VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`');
    }
}
