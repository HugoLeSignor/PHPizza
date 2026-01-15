<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260115120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute les tables dough_type, ingredient et la relation many-to-many pizza_ingredient';
    }

    public function up(Schema $schema): void
    {
        // Créer la table dough_type
        $this->addSql('CREATE TABLE dough_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        // Créer la table ingredient
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        // Créer la table de jointure pizza_ingredient
        $this->addSql('CREATE TABLE pizza_ingredient (pizza_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_6FF6C03FD41D1D42 (pizza_id), INDEX IDX_6FF6C03F933FE08C (ingredient_id), PRIMARY KEY(pizza_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        // Ajouter la colonne dough_type_id à la table pizza
        $this->addSql('ALTER TABLE pizza ADD dough_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE pizza ADD CONSTRAINT FK_CFDD826F7BFE87B FOREIGN KEY (dough_type_id) REFERENCES dough_type (id)');
        $this->addSql('CREATE INDEX IDX_CFDD826F7BFE87B ON pizza (dough_type_id)');
        
        // Ajouter les contraintes de clé étrangère pour pizza_ingredient
        $this->addSql('ALTER TABLE pizza_ingredient ADD CONSTRAINT FK_6FF6C03FD41D1D42 FOREIGN KEY (pizza_id) REFERENCES pizza (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pizza_ingredient ADD CONSTRAINT FK_6FF6C03F933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // Supprimer les contraintes et colonnes de pizza
        $this->addSql('ALTER TABLE pizza DROP FOREIGN KEY FK_CFDD826F7BFE87B');
        $this->addSql('DROP INDEX IDX_CFDD826F7BFE87B ON pizza');
        $this->addSql('ALTER TABLE pizza DROP dough_type_id');
        
        // Supprimer la table de jointure
        $this->addSql('ALTER TABLE pizza_ingredient DROP FOREIGN KEY FK_6FF6C03FD41D1D42');
        $this->addSql('ALTER TABLE pizza_ingredient DROP FOREIGN KEY FK_6FF6C03F933FE08C');
        $this->addSql('DROP TABLE pizza_ingredient');
        
        // Supprimer les nouvelles tables
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE dough_type');
    }
}
