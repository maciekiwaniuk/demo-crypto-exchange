<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221221213950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cryptocurrency (id INT AUTO_INCREMENT NOT NULL, symbol VARCHAR(20) NOT NULL, active VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE log (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, type VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, ip VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8F3F68C59D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, crypto_id_sold_id INT DEFAULT NULL, crypto_id_bought_id INT DEFAULT NULL, type VARCHAR(50) NOT NULL, number_of_crypto_sold DOUBLE PRECISION DEFAULT NULL, number_of_crypto_bought DOUBLE PRECISION DEFAULT NULL, value DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_723705D19D86650F (user_id_id), INDEX IDX_723705D115055639 (crypto_id_sold_id), INDEX IDX_723705D16590170A (crypto_id_bought_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C59D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D19D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D115055639 FOREIGN KEY (crypto_id_sold_id) REFERENCES cryptocurrency (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D16590170A FOREIGN KEY (crypto_id_bought_id) REFERENCES cryptocurrency (id)');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(30) NOT NULL, CHANGE last_login_ip last_login_ip VARCHAR(60) DEFAULT NULL, CHANGE last_login_time last_login_time VARCHAR(50) DEFAULT NULL, CHANGE is_verified is_verified VARCHAR(20) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE log DROP FOREIGN KEY FK_8F3F68C59D86650F');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D19D86650F');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D115055639');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D16590170A');
        $this->addSql('DROP TABLE cryptocurrency');
        $this->addSql('DROP TABLE log');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('ALTER TABLE `user` CHANGE username username VARCHAR(255) NOT NULL, CHANGE last_login_ip last_login_ip VARCHAR(255) DEFAULT NULL, CHANGE last_login_time last_login_time VARCHAR(255) DEFAULT NULL, CHANGE is_verified is_verified TINYINT(1) NOT NULL');
    }
}
