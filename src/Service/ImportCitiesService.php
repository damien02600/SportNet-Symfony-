<?php

namespace App\Service;

use League\Csv\Reader;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportCitiesService
{
    public function importCities(SymfonyStyle $io): void
    {
        $io->title('Importation des villes');
    }

    private function readCsvFile()
    {
        $csv = Reader::createFromPath('%kernel.root_dir%/../import/cities.csv', 'r');

}
}
