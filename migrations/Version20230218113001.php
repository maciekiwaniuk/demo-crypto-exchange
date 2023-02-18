<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230218113001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cryptocurrency (id INT AUTO_INCREMENT NOT NULL, symbol VARCHAR(20) NOT NULL, active VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE log (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, type VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, ip VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8F3F68C5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, crypto_to_sell_id INT DEFAULT NULL, crypto_to_buy_id INT DEFAULT NULL, type VARCHAR(50) NOT NULL, status VARCHAR(255) NOT NULL, attempts INT NOT NULL, amount_of_crypto_to_sell DOUBLE PRECISION DEFAULT NULL, amount_of_crypto_to_buy DOUBLE PRECISION DEFAULT NULL, value DOUBLE PRECISION NOT NULL, done_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F5299398A76ED395 (user_id), INDEX IDX_F5299398212FC935 (crypto_to_sell_id), INDEX IDX_F52993988A7AA766 (crypto_to_buy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, crypto_sold_id INT DEFAULT NULL, crypto_bought_id INT DEFAULT NULL, type VARCHAR(50) NOT NULL, number_of_crypto_sold DOUBLE PRECISION DEFAULT NULL, number_of_crypto_bought DOUBLE PRECISION DEFAULT NULL, value DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_723705D1A76ED395 (user_id), INDEX IDX_723705D119B4E892 (crypto_sold_id), INDEX IDX_723705D14BAE012 (crypto_bought_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(30) NOT NULL, balance DOUBLE PRECISION NOT NULL, last_login_ip VARCHAR(60) DEFAULT NULL, last_login_time VARCHAR(50) DEFAULT NULL, last_user_agent VARCHAR(255) DEFAULT NULL, ban_status VARCHAR(255) NOT NULL, is_verified VARCHAR(20) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C5A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398212FC935 FOREIGN KEY (crypto_to_sell_id) REFERENCES cryptocurrency (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988A7AA766 FOREIGN KEY (crypto_to_buy_id) REFERENCES cryptocurrency (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D119B4E892 FOREIGN KEY (crypto_sold_id) REFERENCES cryptocurrency (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D14BAE012 FOREIGN KEY (crypto_bought_id) REFERENCES cryptocurrency (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE log DROP FOREIGN KEY FK_8F3F68C5A76ED395');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398212FC935');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988A7AA766');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A76ED395');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D119B4E892');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D14BAE012');
        $this->addSql('DROP TABLE cryptocurrency');
        $this->addSql('DROP TABLE log');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
