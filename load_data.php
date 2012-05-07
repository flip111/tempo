<?php

/*
 * This file is part of the Tempo project.
 *
 * (c) Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$rootDir = __DIR__;

require_once __DIR__.'/app/bootstrap.php.cache';

// reset data
$fs = new \Symfony\Component\Filesystem\Filesystem;
$output = new \Symfony\Component\Console\Output\ConsoleOutput();

// does the parent directory have a parameters.yml file
if (is_file(__DIR__.'/../parameters.demo.yml')) {
    $fs->copy(__DIR__.'/../parameters.demo.yml', __DIR__.'/app/config/parameters.yml', true);
}

if (!is_file(__DIR__.'/app/config/parameters.yml')) {
    $output->writeln('<error>no default app/config/parameters.yml file</error>');

    exit(0);
}
/**
 * @param $commands
 * @param \Symfony\Component\Console\Output\ConsoleOutput $output
 * @return void
 */
function execute_commands($commands, $output)
{
    foreach($commands as $command) {
        $output->writeln(sprintf('<info>Executing : </info> %s', $command));
        $p = new \Symfony\Component\Process\Process($command);
        $exit = $p->run(function($type, $data) use ($output) {
            $output->write($data);
        });
        $output->writeln("");
    }
}

$output->writeln("<info>Resetting demo</info>");


execute_commands(array(
    'bin/vendors install',
    'app/console cache:warmup --env=dev',
    'app/console cache:create-cache-class --env=dev',
    'app/console doctrine:schema:update --force',
    'app/console doctrine:fixtures:load --verbose',
    'app/console assets:install --symlink web',
    'app/console cache:warmup --env=prod',
), $output);

$output->writeln('<info>Done!</info>');