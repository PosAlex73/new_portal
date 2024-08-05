<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'phpstan:run',
    description: 'Запускает phpstan для текущего проекта',
)]
class PhpstanRunCommand extends Command
{
    public function __construct(protected ParameterBagInterface $parameterBag,)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        system("./vendor/bin/phpstan analyse -c phpstan.dist.neon --memory-limit 1G");

        return Command::SUCCESS;
    }
}
