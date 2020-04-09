<?php

declare(strict_types=1);

namespace App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200229222440 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE currency (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, symbol VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feed (id INT AUTO_INCREMENT NOT NULL, submission_id VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, path VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, text_id VARCHAR(255) NOT NULL, sku VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_feed (product_id INT NOT NULL, feed_id INT NOT NULL, INDEX IDX_AEA8660A4584665A (product_id), INDEX IDX_AEA8660A51A5BC03 (feed_id), PRIMARY KEY(product_id, feed_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_image (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, path VARCHAR(255) NOT NULL, place VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_64617F034584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_image_feed (product_image_id INT NOT NULL, feed_id INT NOT NULL, INDEX IDX_421DF11EF6154FFA (product_image_id), INDEX IDX_421DF11E51A5BC03 (feed_id), PRIMARY KEY(product_image_id, feed_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_inventory (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_DF8DFCBB4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_inventory_feed (product_inventory_id INT NOT NULL, feed_id INT NOT NULL, INDEX IDX_3A8FF5A9844A8532 (product_inventory_id), INDEX IDX_3A8FF5A951A5BC03 (feed_id), PRIMARY KEY(product_inventory_id, feed_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_price (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, currency_id INT NOT NULL, amount NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_6B9459854584665A (product_id), INDEX IDX_6B94598538248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_price_feed (product_price_id INT NOT NULL, feed_id INT NOT NULL, INDEX IDX_CD75E93A1DA4AD70 (product_price_id), INDEX IDX_CD75E93A51A5BC03 (feed_id), PRIMARY KEY(product_price_id, feed_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_feed ADD CONSTRAINT FK_AEA8660A4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_feed ADD CONSTRAINT FK_AEA8660A51A5BC03 FOREIGN KEY (feed_id) REFERENCES feed (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F034584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_image_feed ADD CONSTRAINT FK_421DF11EF6154FFA FOREIGN KEY (product_image_id) REFERENCES product_image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_image_feed ADD CONSTRAINT FK_421DF11E51A5BC03 FOREIGN KEY (feed_id) REFERENCES feed (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_inventory ADD CONSTRAINT FK_DF8DFCBB4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_inventory_feed ADD CONSTRAINT FK_3A8FF5A9844A8532 FOREIGN KEY (product_inventory_id) REFERENCES product_inventory (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_inventory_feed ADD CONSTRAINT FK_3A8FF5A951A5BC03 FOREIGN KEY (feed_id) REFERENCES feed (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_price ADD CONSTRAINT FK_6B9459854584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_price ADD CONSTRAINT FK_6B94598538248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
        $this->addSql('ALTER TABLE product_price_feed ADD CONSTRAINT FK_CD75E93A1DA4AD70 FOREIGN KEY (product_price_id) REFERENCES product_price (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_price_feed ADD CONSTRAINT FK_CD75E93A51A5BC03 FOREIGN KEY (feed_id) REFERENCES feed (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product_price DROP FOREIGN KEY FK_6B94598538248176');
        $this->addSql('ALTER TABLE product_feed DROP FOREIGN KEY FK_AEA8660A51A5BC03');
        $this->addSql('ALTER TABLE product_image_feed DROP FOREIGN KEY FK_421DF11E51A5BC03');
        $this->addSql('ALTER TABLE product_inventory_feed DROP FOREIGN KEY FK_3A8FF5A951A5BC03');
        $this->addSql('ALTER TABLE product_price_feed DROP FOREIGN KEY FK_CD75E93A51A5BC03');
        $this->addSql('ALTER TABLE product_feed DROP FOREIGN KEY FK_AEA8660A4584665A');
        $this->addSql('ALTER TABLE product_image DROP FOREIGN KEY FK_64617F034584665A');
        $this->addSql('ALTER TABLE product_inventory DROP FOREIGN KEY FK_DF8DFCBB4584665A');
        $this->addSql('ALTER TABLE product_price DROP FOREIGN KEY FK_6B9459854584665A');
        $this->addSql('ALTER TABLE product_image_feed DROP FOREIGN KEY FK_421DF11EF6154FFA');
        $this->addSql('ALTER TABLE product_inventory_feed DROP FOREIGN KEY FK_3A8FF5A9844A8532');
        $this->addSql('ALTER TABLE product_price_feed DROP FOREIGN KEY FK_CD75E93A1DA4AD70');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE feed');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_feed');
        $this->addSql('DROP TABLE product_image');
        $this->addSql('DROP TABLE product_image_feed');
        $this->addSql('DROP TABLE product_inventory');
        $this->addSql('DROP TABLE product_inventory_feed');
        $this->addSql('DROP TABLE product_price');
        $this->addSql('DROP TABLE product_price_feed');
    }
}
