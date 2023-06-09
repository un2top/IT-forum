<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Tag;
use App\Entity\User;
use App\Homework\ArticleContentProviderInterface;
use App\Homework\CommentContentProvider;
use App\Service\FileUploader;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class ArticleFixtures extends BaseFixtures implements DependentFixtureInterface
{
    private static $articleTitles = [
        'Как обучить свой ИИ?',
        'Исследование уязвимостей баз данных',
        'Получение информации из XUQV',
    ];

    private static $articleImages = [
        'article-1.jpg',
        'article-2.jpg',
        'article-3.jpeg',
        'article-4.jpg',
        'article-5.jpg',
        'article-6.jpg',
    ];


    private static $words = ['Кофе', 'Клавиатура', 'Пролить', 'Пить', 'Рукопоп'];


    /**
     * @var ArticleContentProviderInterface
     */
    private ArticleContentProviderInterface $articleContentProvider;
    /**
     * @var CommentContentProvider
     */
    private $commentContentProvider;
    /**
     * @var FileUploader
     */
    private $articleFileUploader;

    public function __construct(
        ArticleContentProviderInterface $articleContentProvider,
        CommentContentProvider          $commentContentProvider,
        FileUploader                    $articleFileUploader)
    {
        $this->articleContentProvider = $articleContentProvider;
        $this->commentContentProvider = $commentContentProvider;
        $this->articleFileUploader = $articleFileUploader;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 25, function (Article $article) use ($manager) {
            $article
                ->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setBody($this->getArticleContent())
                ->setDescription($this->faker->realText(100));

            if ($this->faker->boolean(60)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }
            $fileName = $this->faker->randomElement(self::$articleImages);

            $article
                ->setAuthor($this->getRandomReference(User::class))
                ->setVoteCount($this->faker->numberBetween(-10, 10))
                ->setImageFilename($this->articleFileUploader->uploadFile(new File(dirname(dirname(__DIR__)) . '/' . 'public/images/' . $fileName, $fileName)))
                ->setKeywords($this->faker->realText(50));

            for ($i = 0; $i < $this->faker->numberBetween(2, 10); $i++) {
                $this->addComment($article, $manager);
            }

            /** @var Tag $tags */
            $tags = [];
            for ($i = 0; $i < $this->faker->numberBetween(0, 5); $i++) {
                $tags[] = $this->getRandomReference(Tag::class);
            }

            foreach ($tags as $tag) {
                $article->addTag($tag);
            }

        });
    }

    public function getDependencies()
    {
        return [
            TagFixtures::class,
            UserFixtures::class,
        ];
    }

    private function addComment($article, $manager)
    {
        $word = null;
        $wordsCount = 0;

        if ($this->faker->boolean(70)) {
            $word = $this->faker->randomElement(self::$words);
            $wordsCount = $this->faker->numberBetween(1, 5);
        }

        $comment = (new Comment())
            ->setAuthorName($this->faker->name)
            ->setContent($this->commentContentProvider->get($word, $wordsCount))
            ->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 day'))
            ->setArticle($article);

        if ($this->faker->boolean) {
            $comment->setDeletedAt($this->faker->dateTimeThisMonth);
        }

        $manager->persist($comment);
    }

    private function getArticleContent()
    {
        $word = null;
        $wordsCount = 0;
        $paragraphs = $this->faker->numberBetween(2, 10);

        if ($this->faker->boolean(70)) {
            $word = $this->faker->randomElement(self::$words);
            $wordsCount = $this->faker->numberBetween(2, $paragraphs * 2);
        }

        return $this->articleContentProvider->get($paragraphs, $word, $wordsCount);
    }
}
