<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Tag;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use function Sodium\add;


class ArticleFixtures extends BaseFixtures implements DependentFixtureInterface
{
    private static $articleTitles = [
        'Новости в мире IT',
        'Как я познакомился с девушкой',
        'Когда перепутал соусы...',
        'Бег или скакалка?',
        'Как выучить PHP?',
    ];

    private static $articleAuthors = [
        'Техноблогер',
        'Mr. Black',
        'Барон Сосискин',
        'Noob',
        'Optimus',
    ];

    private static $articleImages = [
        'article-1.jpg',
        'article-2.jpg',
        'article-3.jpg',
        'article-4.jpg',
        'article-5.jpg',
    ];
    private static $articleKeyWord = [
        'новости',
        'обучение',
        'спорт',
        'еда',
        'девушки',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function (Article $article) use ($manager) {
            $article
                ->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setDescription($this->faker->text(75))
                ->setAuthor($this->faker->randomElement(self::$articleAuthors))
                ->setVoteCount($this->faker->numberBetween(-10, 30))
                ->setImageFilename($this->faker->randomElement(self::$articleImages));
            if ($this->faker->boolean(70)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
                $keyWord = $this->faker->randomElement(self::$articleKeyWord);
                $article->setKeywords($keyWord);
                $article->setBody($this->articleContent->get($this->faker->numberBetween(2, 10), $keyWord, $this->faker->numberBetween(5, 15)));
            } else {
                $article->setBody($this->articleContent->get($this->faker->numberBetween(2, 10)));
            }
            for ($i = 0; $i < $this->faker->numberBetween(2, 10); $i++) {
                $this->addComment($article, $manager);
            }
            /** @var Tag[] $tags */
            $tags = [];
            for($i=0;$i<$this->faker->numberBetween(0,5);$i++){
                $tags[]= $this->getRandomReference(Tag::class);
            }
            foreach ($tags as $tag){
                $article->addTag($tag);
            }

        });
    }

    /**
     * @param Article $article
     * @param ObjectManager $manager
     * @return void
     */
    private function addComment(Article $article, ObjectManager $manager): void
    {
        $comment = (new Comment())
            ->setAuthorName($this->faker->randomElement(self::$articleAuthors))
            ->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 day'))
            ->setArticle($article);

        if ($this->faker->boolean(70)) {
            $keyWord = $this->faker->randomElement(self::$articleKeyWord);
            $comment->setContent($this->commentContentProvider->get($keyWord, $this->faker->numberBetween(1, 5)));
        } else {
            $comment->setContent($this->commentContentProvider->get());
        }
        if ($this->faker->boolean) {
            $comment->setDeletedAt($this->faker->dateTimeThisMonth);
        }

        $manager->persist($comment);
    }

    public function getDependencies()
    {
        return [
            TagFixtures::class,
        ];
    }

}
