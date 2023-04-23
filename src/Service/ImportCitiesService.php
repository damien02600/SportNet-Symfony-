<?php

namespace App\Service;

use App\Entity\City;
use League\Csv\Reader;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportCitiesService
{
    public function __construct(
        private CityRepository $cityRepository,
        private EntityManagerInterface $em,
    ) {
    }

    // Cette fonction permet de boucler sur les cities que je récupére grace le fichier csv grace à la fonction readCsvFile plus bas
    public function importCities(SymfonyStyle $io): void
    {
        $io->title('Importation des villes');

        // je récupére grace le fichier csv grace à la fonction readCsvFile
        $cities = $this->readCsvFile();

        $io->progressStart(count($cities));

        // Je boucle sur les city, je stocke chaque city individuellement chaque city sous forme de tableau (arrayCity)
        foreach ($cities as $arrayCity) {
            $io->progressAdvance();
            // J'utilise la fonction createOrUpdateCity pour vérifier ssi elle existe ou pas sinon on la créer
            $city = $this->createOrUpdateCity($arrayCity);
            $this->em->persist($city);
        }

        $this->em->flush();

        $io->progressAdvance();

        $io->success('Importation terminée');
    }

    // Cette va lire ce fichier
    private function readCsvFile(): Reader
    {
        // J'utilise la librairie ligueCSV et j'utilise Reader qui permet de lire le fichier CSV
        $csv = Reader::createFromPath('%kernel.root_dir%/../import/cities.csv', 'r');
        // Je lui dit que la premiére ligne est le libellé des colones
        $csv->setHeaderOffset(0);

        return $csv;
    }

    private function createOrUpdateCity(array $arraycity): City
    {
        $city = $this->cityRepository->findOneBy(['inseeCode' => $arraycity['insee_code']]);

        // Je créer le city si elle existe pas
        if (!$city) {
            $city = new City();
        }

        // Je remplis chaque champ 
        $city->setInseeCode($arraycity['insee_code'])
            ->setCityName($arraycity['city_code'])
            ->setPostalCode($arraycity['zip_code'])
            ->setDepartmentName($arraycity['department_name'])
            ->setRegionName($arraycity['region_name']);

        return $city;
    }
}
