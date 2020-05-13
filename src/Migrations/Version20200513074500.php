<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200513074500 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE landlord (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, family VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, identification_number INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F446E8F8A76ED395 (user_id), UNIQUE INDEX search_landlord_idx (identification_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, api_token VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6497BA2F5EB (api_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assets (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, area_in_decares INT NOT NULL, identification_number VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_79D17D8EA76ED395 (user_id), UNIQUE INDEX search_identification_number_idx (identification_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contracts (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, contract_number VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, type VARCHAR(255) NOT NULL, price NUMERIC(10, 0) DEFAULT NULL, rent_per_decare NUMERIC(10, 0) DEFAULT NULL, INDEX IDX_950A973A76ED395 (user_id), INDEX type_idx (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contract_asset_asset (contract_asset_id INT NOT NULL, asset_id INT NOT NULL, INDEX IDX_D55FADD6906D02BE (contract_asset_id), INDEX IDX_D55FADD65DA1941 (asset_id), PRIMARY KEY(contract_asset_id, asset_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contract_rent_asset (id INT AUTO_INCREMENT NOT NULL, asset_id INT DEFAULT NULL, contract_rent_id INT DEFAULT NULL, landlord_id INT DEFAULT NULL, asset_rent_percent INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_FA9009C35DA1941 (asset_id), INDEX IDX_FA9009C3EDAC1F98 (contract_rent_id), INDEX IDX_FA9009C3D48E7AED (landlord_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE landlord ADD CONSTRAINT FK_F446E8F8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE assets ADD CONSTRAINT FK_79D17D8EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contracts ADD CONSTRAINT FK_950A973A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contract_asset_asset ADD CONSTRAINT FK_D55FADD6906D02BE FOREIGN KEY (contract_asset_id) REFERENCES contracts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contract_asset_asset ADD CONSTRAINT FK_D55FADD65DA1941 FOREIGN KEY (asset_id) REFERENCES assets (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contract_rent_asset ADD CONSTRAINT FK_FA9009C35DA1941 FOREIGN KEY (asset_id) REFERENCES assets (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE contract_rent_asset ADD CONSTRAINT FK_FA9009C3EDAC1F98 FOREIGN KEY (contract_rent_id) REFERENCES contracts (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE contract_rent_asset ADD CONSTRAINT FK_FA9009C3D48E7AED FOREIGN KEY (landlord_id) REFERENCES landlord (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contract_rent_asset DROP FOREIGN KEY FK_FA9009C3D48E7AED');
        $this->addSql('ALTER TABLE landlord DROP FOREIGN KEY FK_F446E8F8A76ED395');
        $this->addSql('ALTER TABLE assets DROP FOREIGN KEY FK_79D17D8EA76ED395');
        $this->addSql('ALTER TABLE contracts DROP FOREIGN KEY FK_950A973A76ED395');
        $this->addSql('ALTER TABLE contract_asset_asset DROP FOREIGN KEY FK_D55FADD65DA1941');
        $this->addSql('ALTER TABLE contract_rent_asset DROP FOREIGN KEY FK_FA9009C35DA1941');
        $this->addSql('ALTER TABLE contract_asset_asset DROP FOREIGN KEY FK_D55FADD6906D02BE');
        $this->addSql('ALTER TABLE contract_rent_asset DROP FOREIGN KEY FK_FA9009C3EDAC1F98');
        $this->addSql('DROP TABLE landlord');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE assets');
        $this->addSql('DROP TABLE contracts');
        $this->addSql('DROP TABLE contract_asset_asset');
        $this->addSql('DROP TABLE contract_rent_asset');
    }
}
