<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\Exception\AbortMigration;

final class Version20260114120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create pizza table with unique special ingredient';
    }

    /**
     * @throws AbortMigration
     */
    public function up(Schema $schema): void
    {
        if (!$this->connection->getDatabasePlatform() instanceof MySQLPlatform) {
            throw new AbortMigration('Migration can only be executed safely on mysql.');
        }

        $this->addSql('CREATE TABLE pizza (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, special_ingredient VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT "(DC2Type:datetime_immutable)", UNIQUE INDEX unique_special_ingredient (special_ingredient), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    /**
     * @throws AbortMigration
     */
    public function down(Schema $schema): void
    {
        if (!$this->connection->getDatabasePlatform() instanceof MySQLPlatform) {
            throw new AbortMigration('Migration can only be executed safely on mysql.');
        }

        $this->addSql('DROP TABLE pizza');
    }
}
