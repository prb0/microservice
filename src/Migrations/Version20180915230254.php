<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180915230254 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, subscriber_id INT DEFAULT NULL, text LONGTEXT NOT NULL, INDEX IDX_B6BD307F7808B1AD (subscriber_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscriber (id INT AUTO_INCREMENT NOT NULL, messenger_id INT DEFAULT NULL, messenger_subscriber_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_AD005B69676C7AF5 (messenger_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F7808B1AD FOREIGN KEY (subscriber_id) REFERENCES subscriber (id)');
        $this->addSql('ALTER TABLE subscriber ADD CONSTRAINT FK_AD005B69676C7AF5 FOREIGN KEY (messenger_id) REFERENCES messenger (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE subscriber DROP FOREIGN KEY FK_AD005B69676C7AF5');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F7808B1AD');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE messenger');
        $this->addSql('DROP TABLE subscriber');
        $this->addSql('DROP TABLE user');
    }
}
