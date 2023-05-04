<?php

namespace SymfonySkillbox\SymfonySkillboxHomeworkBundle;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ProduceUnitsCommand extends Command
{

    protected static $defaultName = 'symfony-skillbox-homework:produce-units';
    protected static $defaultDescription = 'Покупка юнитов';
    /**
     * @var UnitFactory
     */
    private $unitFactory;


    public function __construct(UnitFactory $unitFactory)
    {
        parent::__construct();
        $this->unitFactory = $unitFactory;
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('money', InputArgument::REQUIRED, 'Наличие золота')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $money = $input->getArgument('money');
        $army = $this->unitFactory->produceUnits($money);
        $allArmy = [];
        foreach ($army[0] as $unit){
            $allArmy[]=[$unit->getName(), $unit->getCost(),$unit->getStrength(), $unit->getHealth(),];
        }
        $header = ['Имя', 'Цена','Сила','Здоровье',];

        $io->text(sprintf('на %d было куплено %d юнитов', $money, count($allArmy)));
        $io->table($header, $allArmy);
        $io->text(sprintf('Осталось ресурсов: %d', $army[1]));

        return 0;
    }
}
