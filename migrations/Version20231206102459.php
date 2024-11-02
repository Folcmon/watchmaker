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
        $this->addSql('Insert into vat_rate (rate_name,rate_value) values ("23%", 23)');
        $this->addSql('Insert into vat_rate (rate_name,rate_value) values ("8%", 8)');
        $this->addSql('Insert into vat_rate (rate_name,rate_value) values ("5%", 5)');
        $this->addSql('Insert into vat_rate (rate_name,rate_value) values ("0%", 0)');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
