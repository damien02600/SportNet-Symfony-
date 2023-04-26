<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use App\Service\ImportLevelsService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:import-levels')]
class ImportLevelsCommand extends Command
{
    public function __construct(
private ImportLevelsService $ImportLevelsCommand
    ) {
    parent::__construct();  
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // SymfonyStyle permet de faire de la mise en page dans le terminal
        $io = new SymfonyStyle($input, $output);
        $this->ImportLevelsCommand->importLevels($io);

        return Command::SUCCESS;
    }
}