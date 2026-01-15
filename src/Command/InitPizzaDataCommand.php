<?php

namespace App\Command;

use App\Entity\DoughType;
use App\Entity\Ingredient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:init-pizza-data',
    description: 'Initialise les types de pâte et les ingrédients de base',
)]
class InitPizzaDataCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Initialiser les types de pâte
        $doughTypes = ['Fine', 'Épaisse', 'Mixte'];
        foreach ($doughTypes as $typeName) {
            $existing = $this->entityManager->getRepository(DoughType::class)
                ->findOneBy(['name' => $typeName]);

            if (!$existing) {
                $doughType = new DoughType();
                $doughType->setName($typeName);
                $this->entityManager->persist($doughType);
                $io->success("Type de pâte '$typeName' créé.");
            } else {
                $io->note("Type de pâte '$typeName' existe déjà.");
            }
        }

        // Initialiser les ingrédients classiques
        $ingredients = [
            'Tomate',
            'Mozzarella',
            'Basilic',
            'Jambon',
            'Champignons',
            'Olives',
            'Poivrons',
            'Oignons',
            'Anchois',
            'Pepperoni',
            'Roquette',
            'Parmesan',
            'Œuf',
            'Thon',
            'Artichauts'
        ];

        foreach ($ingredients as $ingredientName) {
            $existing = $this->entityManager->getRepository(Ingredient::class)
                ->findOneBy(['name' => $ingredientName]);

            if (!$existing) {
                $ingredient = new Ingredient();
                $ingredient->setName($ingredientName);
                $this->entityManager->persist($ingredient);
                $io->success("Ingrédient '$ingredientName' créé.");
            } else {
                $io->note("Ingrédient '$ingredientName' existe déjà.");
            }
        }

        $this->entityManager->flush();

        $io->success('Les données de base ont été initialisées avec succès !');

        return Command::SUCCESS;
    }
}
