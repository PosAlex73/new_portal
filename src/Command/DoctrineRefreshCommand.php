<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'doctrine:refresh',
    description: 'Целиком удаляет базу данных и накатывает все фикстуры',
)]
class DoctrineRefreshCommand extends Command
{
    public function __construct(
        protected ParameterBagInterface $parameterBag,
        protected EntityManagerInterface $entityManager
    ){
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $projectDir = $this->parameterBag->get('kernel.project_dir');

        $schemaManager = $this->entityManager->getConnection()->createSchemaManager();
        $availableDatabases = $schemaManager->listDatabases();

        if (in_array('app', $availableDatabases)) {
            try {
                $schemaManager->dropDatabase('app');
            } catch (\Throwable $throwable) {
                $output->writeln('Не удалось удалить базу данных');
                $output->writeln($throwable->getMessage());
                return Command::FAILURE;
            }
        }
        system("php $projectDir/bin/console doctrine:database:create");
        system("php $projectDir/bin/console doctrine:schema:create");
        system("yes | php $projectDir/bin/console doctrine:fixtures:load");

        return Command::SUCCESS;
    }
}
