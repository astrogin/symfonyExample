<?php

declare(strict_types=1);

namespace App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200304162406 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD product_data_main_category VARCHAR(255) NOT NULL, ADD product_type_main_category VARCHAR(255) DEFAULT NULL, ADD minimum_manufacturer_age_recommended_unit_of_measure VARCHAR(255) DEFAULT NULL, ADD minimum_manufacturer_age_recommended_value VARCHAR(255) DEFAULT NULL, DROP product_data');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD product_data MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP product_data_main_category, DROP product_type_main_category, DROP minimum_manufacturer_age_recommended_unit_of_measure, DROP minimum_manufacturer_age_recommended_value');
    }
}
