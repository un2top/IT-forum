<?php

namespace App\Events;

use App\Entity\Article;
use Symfony\Contracts\EventDispatcher\Event;

class ArticleCreateEvent extends Event
{

    /**
     * @var Article
     */
    private $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->article;
    }

}
