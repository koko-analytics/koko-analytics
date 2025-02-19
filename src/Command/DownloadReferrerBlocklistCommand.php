<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:download-referrer-blocklist', description: 'Downloads a community maintained referrer blocklist')]
class DownloadReferrerBlocklistCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $blocklist = file_get_contents("https://raw.githubusercontent.com/matomo-org/referrer-spam-blacklist/master/spammers.txt");
        if (!$blocklist) {
            $output->writeln("Error downloading blocklist");
            return Command::FAILURE;
        }

        $filename = dirname(__DIR__, 2) . '/var/blocklist.txt';
        file_put_contents($filename, $blocklist);
        $output->writeln("Downloaded blocklist to '$filename'");
        return Command::SUCCESS;
    }
}
