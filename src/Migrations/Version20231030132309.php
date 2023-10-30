<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231030132309 extends AbstractMigration
{
    /**
     * @var array
     */
    private $tablesToInstall = [
        'mm2_to_awg_conversion' =>
        "CREATE TABLE IF NOT EXISTS `mm2_to_awg_conversion` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `mm2` decimal(10,2) DEFAULT NULL,
                `awg` varchar(255) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            INSERT INTO `mm2_to_awg_conversion` (`mm2`, `awg`) VALUES
            (0.05,'AWG30'),
            (0.08,'AWG28'),
            (0.09,'AWG28'),
            (0.14,'AWG26'),
            (0.16,'AWG25'),
            (0.18,'AWG25'),
            (0.20,'AWG24'),
            (0.22,'AWG24'),
            (0.23,'AWG24'),
            (0.25,'AWG24'),
            (0.30,'AWG23'),
            (0.34,'AWG22'),
            (0.35,'AWG22'),
            (0.50,'AWG21'),
            (0.75,'AWG19'),
            (1.00,'AWG18'),
            (1.50,'AWG16'),
            (2.50,'AWG14'),
            (4.00,'AWG12'),
            (6.00,'AWG10'),
            (10.00,'AWG08'),
            (16.00,'AWG06'),
            (25.00,'AWG04'),
            (35.00,'AWG02'),
            (50.00,'AWG01'),
            (52.00,'AWG1/0'),
            (70.00,'AWG2/0'),
            (95.00,'AWG3/0'),
            (120.00,'AWG4/0');"
    ];

    public function getDescription(): string
    {
        return "Create the 'mm2_to_awg_conversion' table";
    }


    public function up(Schema $schema): void
    {
        foreach ($this->tablesToInstall as $name => $statement) {
            if ($schema->hasTable($name)) {

                continue;
            }

            $this->addSql($statement);
        }

    }

    public function down(Schema $schema): void
    {
        foreach (array_keys($this->tablesToInstall) as $table) {
            if (!$schema->hasTable($table)) {

                continue;
            }

            $schema->dropTable($table);
        }
    }
}
