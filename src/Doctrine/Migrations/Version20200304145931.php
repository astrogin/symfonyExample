<?php

declare(strict_types=1);

namespace App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200304145931 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD product_tax_code VARCHAR(255) NOT NULL, ADD launch_date DATETIME NOT NULL, ADD release_date DATETIME NOT NULL, ADD bullet_point LONGTEXT DEFAULT NULL, ADD item_type VARCHAR(255) NOT NULL, ADD target_audience LONGTEXT NOT NULL, ADD product_data MEDIUMTEXT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP product_tax_code, DROP launch_date, DROP release_date, DROP bullet_point, DROP item_type, DROP target_audience, DROP product_data');
    }
}
