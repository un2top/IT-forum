<?php

namespace App\Command;

use App\Homework\ArticleContentProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ArticleContentProviderCommand extends Command
{
    protected static $defaultName = 'app:article:content_provider';
    protected static $defaultDescription = 'Выводит текст статьи';

    private $articleContentProvider;


    public function __construct(ArticleContentProvider $articleContentProvider)
    {
        $this->articleContentProvider = $articleContentProvider;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('paragraphs', InputArgument::REQUIRED, 'Количество абзацев')
            ->addArgument('word', InputArgument::OPTIONAL, 'ключевое слово')
            ->addArgument('wordsCount', InputArgument::OPTIONAL, 'количество ключевых слов', 0)
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $paragraphs = $input->getArgument('paragraphs');
        $word = $input->getArgument('word');
        $wordsCount = $input->getArgument('wordsCount');


            $io->note(sprintf('Text:'.$this->articleContentProvider->get($paragraphs,$word, $wordsCount)));


        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
