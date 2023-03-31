<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;


class ArticleFixtures extends BaseFixtures
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
        $this->createMany(Article::class, 10, function (Article $article) {
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
        });
    }
}
