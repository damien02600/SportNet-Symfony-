<?php

namespace App\Service;

use App\Entity\Sports;
use League\Csv\Reader;
use App\Repository\SportsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportSportsService
{
    public function __construct(
        private SportsRepository $sportRepository,
        private EntityManagerInterface $em,
    ) {
    }

    // Cette fonction permet de boucler sur les cities que je récupére grace le fichier csv grace à la fonction readCsvFile plus bas
    public function importSports(SymfonyStyle $io): void
    {
        $io->title('Importation des sports');

        // je récupére grace le fichier csv grace à la fonction readCsvFile
        $sports = $this->readCsvFile();

        $io->progressStart(count($sports));

        // Je boucle sur les city, je stocke chaque city individuellement chaque city sous forme de tableau (arrayCity)
        foreach ($sports as $arraySport) {
            $io->progressAdvance();
            // J'utilise la fonction createOrUpdateCity pour vérifier ssi elle existe ou pas sinon on la créer
            $sport = $this->createOrUpdateSport($arraySport);
            $this->em->persist($sport);
        }

        $this->em->flush();

        $io->progressAdvance();

        $io->success('Importation terminée');
    }

    // Cette va lire ce fichier
    private function readCsvFile(): Reader
    {
        // J'utilise la librairie ligueCSV et j'utilise Reader qui permet de lire le fichier CSV
        $csv = Reader::createFromPath('%kernel.root_dir%/../import/sports.csv', 'r');
        // Je lui dit que la premiére ligne est le libellé des colones
        $csv->setHeaderOffset(0);

        return $csv;
    }

    private function createOrUpdateSport(array $arraysport): Sports
    {
        $sport = $this->sportRepository->findOneBy(['name' => $arraysport['name']]);

        // Je créer le city si elle existe pas
        if (!$sport) {
            $sport = new Sports();
        }

        // Je remplis chaque champ 
        $sport->setName($arraysport['name']);

        return $sport;
    }
}
