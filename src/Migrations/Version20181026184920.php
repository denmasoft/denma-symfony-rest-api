<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181026184920 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP TABLE fracciones');
        $this->addSql('DROP TABLE subpartidas');
        $this->addSql('DROP TABLE partidas');
        $this->addSql('DROP TABLE capitulos');
        $this->addSql('DROP TABLE secciones');
        $this->addSql('DROP TABLE tigie_fracciones');
        $this->addSql('DROP TABLE tigie_subpartidas');
        $this->addSql('DROP TABLE tigie_partidas');
        $this->addSql('DROP TABLE tigie_capitulos');
        $this->addSql('DROP TABLE tigie_secciones');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
    }
}
