<?php

declare(strict_types=1);

/*
 * This file is part of the G.L.S.R. Apps package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Unit\Tests\Infrastructure;

use Symfony\Component\Process\Process;

abstract class DatabaseHelper
{
    private static $done = false;

    public static function dropDatabase(): void
    {
        $process = new Process(
            [
                'php',
                'bin/console',
                'doctrine:database:drop',
                '--force',
                '--if-exists',
            ],
            \dirname(__DIR__, 3)
        );

        $process->run();

        if (!$process->isSuccessful()) {
            \var_dump($process->getErrorOutput());
            die(\var_dump($process));
        }
    }

    public static function createDatabase(): void
    {
        $process = new Process(
            [
                'php',
                'bin/console',
                'doctrine:database:create',
            ],
            \dirname(__DIR__, 3)
        );

        $process->run();

        if (!$process->isSuccessful()) {
            \var_dump($process->getErrorOutput());
            die(\var_dump($process));
        }
    }

    public static function runMigrations(): void
    {
        self::$done = true;
        $process = new Process(
            [
                'php',
                'bin/console',
                'doctrine:migrations:migrate',
                '-n',
            ],
            \dirname(__DIR__, 3)
        );

        $process->run();

        if (!$process->isSuccessful()) {
            \var_dump($process->getErrorOutput());
            die(\var_dump($process));
        }
    }

    public static function loadFixtures(array $options = []): void
    {
        $command = [
            'php',
            'bin/console',
            'doctrine:fixtures:load',
            '-n',
        ];
        if (!empty($options)) {
            foreach ($options as $key => $value) {
                $command[] = '--' . $key . '=' . $value;
            }
        }
        $process = new Process(
            $command,
            \dirname(__DIR__, 3)
        );

        $process->run();

        if (!$process->isSuccessful()) {
            \var_dump($process->getErrorOutput());
            die(\var_dump($process));
        }
    }

    public static function dropAndCreateDatabaseAndRunMigrations(): void
    {
        if (!self::$done) {
            self::dropDatabase();
            self::createDatabase();
            self::runMigrations();
        }
    }
}
