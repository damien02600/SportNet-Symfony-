<?php

namespace App\Service;

use App\Entity\Level;
use League\Csv\Reader;
use App\Repository\LevelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportLevelsService
{
    public function __construct(
        private LevelRepository $levelRepository,
        private EntityManagerInterface $em,
    ) {
    }

    // Cette fonction permet de boucler sur les cities que je récupére grace le fichier csv grace à la fonction readCsvFile plus bas
    public function importLevels(SymfonyStyle $io): void
    {
        $io->title('Importation des niveau');

        // je récupére grace le fichier csv grace à la fonction readCsvFile
        $levels = $this->readCsvFile();

        $io->progressStart(count($levels));

        // Je boucle sur les city, je stocke chaque city individuellement chaque city sous forme de tableau (arrayCity)
        foreach ($levels as $arrayLevel) {
            $io->progressAdvance();
            // J'utilise la fonction createOrUpdateCity pour vérifier ssi elle existe ou pas sinon on la créer
            $level = $this->createOrUpdateLevel($arrayLevel);
            $this->em->persist($level);
        }

        $this->em->flush();

        $io->progressAdvance();

        $io->success('Importation terminée');
    }

    // Cette va lire ce fichier
    private function readCsvFile(): Reader
    {
        // J'utilise la librairie ligueCSV et j'utilise Reader qui permet de lire le fichier CSV
        $csv = Reader::createFromPath('%kernel.root_dir%/../import/levels.csv', 'r');
        // Je lui dit que la premiére ligne est le libellé des colones
        $csv->setHeaderOffset(0);

        return $csv;
    }

    private function createOrUpdateLevel(array $arraylevel): Level
    {
        $level = $this->levelRepository->findOneBy(['name' => $arraylevel['name']]);


        // Je créer le city si elle existe pas
        if (!$level) {
            $level = new Level();
        }

        // Je remplis chaque champ 
        $level->setName($arraylevel['name']);

        return $level;
    }
}
