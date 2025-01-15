<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206102459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('Insert into vat_rate (rate_name,rate_value,created_at,updated_at) values ("23%", 23, now(), now())');
        $this->addSql('Insert into vat_rate (rate_name,rate_value,created_at,updated_at) values ("8%", 8,now(), now())');
        $this->addSql('Insert into vat_rate (rate_name,rate_value,created_at,updated_at) values ("5%", 5,now(), now())');
        $this->addSql('Insert into vat_rate (rate_name,rate_value,created_at,updated_at) values ("0%", 0,now(), now())');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
