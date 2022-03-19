<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use App\Migration\AbstractBFMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317202851 extends AbstractBFMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->insertVKAccountV0('380732439485', '1q23rtczxc', 712795075);
    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException();
    }
}
