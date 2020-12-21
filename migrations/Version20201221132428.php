<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201221132428 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prestation (id INT AUTO_INCREMENT NOT NULL, organisation_id INT NOT NULL, object_id INT NOT NULL, gauge_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, email VARCHAR(50) NOT NULL, message LONGTEXT NOT NULL, title VARCHAR(100) DEFAULT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_51C88FAD9E6B1585 (organisation_id), INDEX IDX_51C88FAD232D562B (object_id), INDEX IDX_51C88FAD77C81DA6 (gauge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestation_user (prestation_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D127F0F59E45C554 (prestation_id), INDEX IDX_D127F0F5A76ED395 (user_id), PRIMARY KEY(prestation_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prestation ADD CONSTRAINT FK_51C88FAD9E6B1585 FOREIGN KEY (organisation_id) REFERENCES prestation_organization (id)');
        $this->addSql('ALTER TABLE prestation ADD CONSTRAINT FK_51C88FAD232D562B FOREIGN KEY (object_id) REFERENCES prestation_object (id)');
        $this->addSql('ALTER TABLE prestation ADD CONSTRAINT FK_51C88FAD77C81DA6 FOREIGN KEY (gauge_id) REFERENCES prestation_gauge (id)');
        $this->addSql('ALTER TABLE prestation_user ADD CONSTRAINT FK_D127F0F59E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestation_user ADD CONSTRAINT FK_D127F0F5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestation_user DROP FOREIGN KEY FK_D127F0F59E45C554');
        $this->addSql('DROP TABLE prestation');
        $this->addSql('DROP TABLE prestation_user');
    }
}
