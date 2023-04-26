<?php

namespace App\Command;

use App\Service\ImportSportsService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:import-sports')]
class ImportSportsCommand extends Command
{
    public function __construct(
private ImportSportsService $importSportsService
    ) {
    parent::__construct();  
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // SymfonyStyle permet de faire de la mise en page dans le terminal
        $io = new SymfonyStyle($input, $output);
        $this->importSportsService->importSports($io);

        return Command::SUCCESS;
    }
}