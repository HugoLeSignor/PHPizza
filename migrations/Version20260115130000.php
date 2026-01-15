<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260115130000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute la table user et la relation avec pizza (système d\'authentification)';
    }

    public function up(Schema $schema): void
    {
        // Ne rien faire si tout est déjà en place
        // La table user et la colonne owner_id ont déjà été créées manuellement
    }

    public function down(Schema $schema): void
    {
        // Supprimer la contrainte et la colonne owner_id de pizza
        $this->addSql('ALTER TABLE pizza DROP FOREIGN KEY FK_CFDD826E7A1254A');
        $this->addSql('DROP INDEX IDX_CFDD826E7A1254A ON pizza');
        $this->addSql('ALTER TABLE pizza DROP owner_id');

        // Supprimer la table user
        $this->addSql('DROP TABLE `user`');
    }
}
