<?php

namespace App\Command;

use App\Entity\Brand;
use App\Entity\Model;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:brand-models-import',
    description: 'Add a short description for your command',
)]
class BrandModelsImportCommand extends Command
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('filePath', InputArgument::OPTIONAL, 'Path to the JSON file with watch brands and models');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($filePath = $input->getArgument('filePath')) {
            $jsonFile = $filePath;
        } else {
            $jsonFile = __DIR__ . '/../../public/watchBrands.json';
        }
        if (!file_exists($jsonFile)) {
            $io->error('JSON file not found');
            return Command::FAILURE;
        }

        $jsonData = file_get_contents($jsonFile);
        $brandsData = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $io->error('Invalid JSON data');
            return Command::FAILURE;
        }

        foreach ($brandsData['brands'] as $brandData) {
            $brand = new Brand();
            $brand->setName($brandData['name']);
            $this->entityManager->persist($brand);

            foreach ($brandData['models'] as $modelName) {
                $model = new Model();
                $model->setName($modelName);
                $model->setBrand($brand);
                $this->entityManager->persist($model);
            }
        }

        $this->entityManager->flush();

        $io->success('Watch brands and models have been successfully imported.');

        return Command::SUCCESS;
    }
}