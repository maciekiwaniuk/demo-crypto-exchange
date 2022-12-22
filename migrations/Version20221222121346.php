<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221222121346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE log DROP FOREIGN KEY FK_8F3F68C59D86650F');
        $this->addSql('DROP INDEX IDX_8F3F68C59D86650F ON log');
        $this->addSql('ALTER TABLE log CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C5A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_8F3F68C5A76ED395 ON log (user_id)');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D115055639');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D16590170A');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D19D86650F');
        $this->addSql('DROP INDEX IDX_723705D16590170A ON transaction');
        $this->addSql('DROP INDEX IDX_723705D19D86650F ON transaction');
        $this->addSql('DROP INDEX IDX_723705D115055639 ON transaction');
        $this->addSql('ALTER TABLE transaction ADD crypto_sold_id INT DEFAULT NULL, ADD crypto_bought_id INT DEFAULT NULL, DROP crypto_id_sold_id, DROP crypto_id_bought_id, CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D119B4E892 FOREIGN KEY (crypto_sold_id) REFERENCES cryptocurrency (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D14BAE012 FOREIGN KEY (crypto_bought_id) REFERENCES cryptocurrency (id)');
        $this->addSql('CREATE INDEX IDX_723705D1A76ED395 ON transaction (user_id)');
        $this->addSql('CREATE INDEX IDX_723705D119B4E892 ON transaction (crypto_sold_id)');
        $this->addSql('CREATE INDEX IDX_723705D14BAE012 ON transaction (crypto_bought_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE log DROP FOREIGN KEY FK_8F3F68C5A76ED395');
        $this->addSql('DROP INDEX IDX_8F3F68C5A76ED395 ON log');
        $this->addSql('ALTER TABLE log CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C59D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8F3F68C59D86650F ON log (user_id_id)');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A76ED395');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D119B4E892');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D14BAE012');
        $this->addSql('DROP INDEX IDX_723705D1A76ED395 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D119B4E892 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D14BAE012 ON transaction');
        $this->addSql('ALTER TABLE transaction ADD crypto_id_sold_id INT DEFAULT NULL, ADD crypto_id_bought_id INT DEFAULT NULL, DROP crypto_sold_id, DROP crypto_bought_id, CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D115055639 FOREIGN KEY (crypto_id_sold_id) REFERENCES cryptocurrency (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D16590170A FOREIGN KEY (crypto_id_bought_id) REFERENCES cryptocurrency (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D19D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_723705D16590170A ON transaction (crypto_id_bought_id)');
        $this->addSql('CREATE INDEX IDX_723705D19D86650F ON transaction (user_id_id)');
        $this->addSql('CREATE INDEX IDX_723705D115055639 ON transaction (crypto_id_sold_id)');
    }
}
