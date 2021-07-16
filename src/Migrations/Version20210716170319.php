<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210716170319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_notifications (id INT AUTO_INCREMENT NOT NULL, recipient_id INT DEFAULT NULL, sender_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, parameters LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', read_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', clickAction_route VARCHAR(255) DEFAULT NULL, clickAction_parameters LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_FA7D8D7FE92F8F78 (recipient_id), INDEX IDX_FA7D8D7FF624B39D (sender_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_notifications ADD CONSTRAINT FK_FA7D8D7FE92F8F78 FOREIGN KEY (recipient_id) REFERENCES sylius_admin_user (id)');
        $this->addSql('ALTER TABLE app_notifications ADD CONSTRAINT FK_FA7D8D7FF624B39D FOREIGN KEY (sender_id) REFERENCES sylius_customer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE app_notifications');
    }
}
