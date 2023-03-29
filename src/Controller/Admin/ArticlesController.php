<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Homework\ArticleContentProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/admin/articles/create", name="app_admin_articles_create")
     */
    public function create(ArticleContentProvider $articleContentProvider, EntityManagerInterface $em)
    {
        $article = new Article();
        $words = ['новости', 'политика', 'спорт', 'еда', 'девушки'];
        $article
            ->setTitle('Что делать, если надо верстать?')
            ->setSlug('what-to-do-if-need-fronted-' . rand(1, 99))
            ->setDescription('Pess persuadere, tanquam ferox bursa. Credere aliquando ducunt ad camerarius detrius.')
            ->setAuthor('Техноблогер')
            ->setKeywords($words[array_rand($words, 1)])
            ->setVoteCount(10)
            ->setImageFilename('article-' . rand(1, 5) . '.jpg');
        if (rand(1, 10) > 3) {
            $article->setPublishedAt(new \DateTime(sprintf('-%d days', rand(0, 50))));
            $keyWord = $words[array_rand($words, 1)];
            $article->setKeywords($keyWord);
            $article->setBody($articleContentProvider->get(5, $keyWord, rand(1, 5)));
        } else {
            $article->setBody($articleContentProvider->get(mt_rand(1, 5)));
        }

        $em->persist($article);
        $em->flush();

        return new Response(sprintf('Создана статья id: %d slug %s',
                $article->getId(),
                $article->getSlug())
        );
    }
}
