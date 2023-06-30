<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230629135505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notification_notification (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', sent_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', type JSON NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification_recipient (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', notification_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', recipient_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', `read` TINYINT(1) NOT NULL, INDEX IDX_CEEDBC16EF1A9D84 (notification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notification_recipient ADD CONSTRAINT FK_CEEDBC16EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification_notification (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification_recipient DROP FOREIGN KEY FK_CEEDBC16EF1A9D84');
        $this->addSql('DROP TABLE notification_notification');
        $this->addSql('DROP TABLE notification_recipient');
    }
}
