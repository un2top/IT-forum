<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserDeactivateCommand extends Command
{

    protected static $defaultName = 'app:user:deactivate';
    protected static $defaultDescription = 'Активация/деактивация пользователя';
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $manager)
    {
        $this->userRepository = $userRepository;
        parent::__construct();
        $this->manager = $manager;
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('id', InputArgument::REQUIRED, 'ID пользователя')
            ->addOption('reverse', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $id = $input->getArgument('id');
        $user = $this->userRepository->findOneBy(['id' => $id]);
        if (is_null($user)) {
            $io->warning('Пользователя с таким ID нет');
        } else {
            if ($input->getOption('reverse')) {
                $user->setIsActive(true);
            } else  $user->setIsActive(false);
            $this->manager->flush();
            $io->success("Команда выполнена");
        }
        return 0;
    }
}
