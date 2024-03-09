<?php

namespace App\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'tests:run',
    description: 'Запускает тесты на базе данных',
)]
class TestsRunCommand extends Command
{
    public function __construct(
        protected ParameterBagInterface $parameterBag,
        protected EntityManagerInterface $entityManager
    ){
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $projectDir = $this->parameterBag->get('kernel.project_dir');

        $schemaManager = $this->entityManager->getConnection()->createSchemaManager();
        $availableDatabases = $schemaManager->listDatabases();

        if (in_array('app_test', $availableDatabases)) {
            try {
                $schemaManager->dropDatabase('app_test');
            } catch (\Throwable $throwable) {
                $output->writeln('Не удалось удалить базу данных');
                $output->writeln($throwable->getMessage());
                return Command::FAILURE;
            }
        }

        system("php $projectDir/bin/console --env=test doctrine:database:create");
        system("php $projectDir/bin/console --env=test doctrine:schema:create");
        system("yes | php $projectDir/bin/console --env=test doctrine:fixtures:load");

        system("php $projectDir/vendor/bin/codecept run");

        return Command::SUCCESS;
    }
}
