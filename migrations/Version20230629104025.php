<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230629104025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message_account (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_EDBE6CA85E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_message (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', sender_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', sent_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', value LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_recipient (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', message_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', recipient_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_2BDFD7F537A1329 (message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_recipient ADD CONSTRAINT FK_2BDFD7F537A1329 FOREIGN KEY (message_id) REFERENCES message_message (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message_recipient DROP FOREIGN KEY FK_2BDFD7F537A1329');
        $this->addSql('DROP TABLE message_account');
        $this->addSql('DROP TABLE message_message');
        $this->addSql('DROP TABLE message_recipient');
    }
}
