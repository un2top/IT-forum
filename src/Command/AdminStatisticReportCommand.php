<?php

namespace App\Command;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class   AdminStatisticReportCommand extends Command
{

    protected static $defaultName = 'app:admin-statistic-report';
    protected static $defaultDescription = 'Отчет по статьям за период';
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ArticleRepository
     */
    private $articleRepository;
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(UserRepository $userRepository, ArticleRepository $articleRepository, MailerInterface $mailer)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
        $this->mailer = $mailer;
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('email', InputArgument::OPTIONAL, 'email пользователя', 'admin@symfony.skillbox')
            ->addOption('dateFrom', null, InputOption::VALUE_OPTIONAL, 'Дата начала периода, по умолчанию: "-1 неделя"', (new \DateTime('-1 week'))->format('Y-m-d'))
            ->addOption('dateTo', null, InputOption::VALUE_OPTIONAL, 'Дата окончания периода, по умолчанию: "сегодня"', (new \DateTime)->format('Y-m-d')) ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $dateFrom = $input->getOption('dateFrom');
        $dateTo = $input->getOption('dateTo');

        /** @var User[] $users */
        $users = $this->userRepository->findAll();

        /** @var Article[] $articles */
        $articlesPublished = $this->articleRepository->findAllPublishedFromInterval($dateFrom, $dateTo);

        /** @var Article[] $articles */
        $articlesCreated = $this->articleRepository->findAllCreatedFromInterval($dateFrom, $dateTo);

        $list = array (
            array('Период', 'Всего пользователей', 'Статей создано за период', 'Статей опубликовано за период'),
            array($dateFrom .'-'.$dateTo, count($users), count($articlesCreated), count($articlesPublished)),
        );

        $fp = fopen('public/reports/adminstatisticreport.csv', 'w');

        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);

        $email = (new TemplatedEmail())
            ->from(new Address('noreply@symfony.skillbox', 'Spill-Coffee-On-The-Keyboard'))
            ->to($input->getArgument('email'))
            ->subject('Отчет Spill-Coffee-On-The-Keyboard')
            ->text('Отчет за данный период')
            ->attachFromPath('public/reports/adminstatisticreport.csv');

        $this->mailer->send($email);

        return 0;
    }
}
