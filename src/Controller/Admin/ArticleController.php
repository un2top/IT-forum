<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/admin/articles/create", name="app_admin_article_create")
     * @IsGranted ("ROLE_ADMIN_ARTICLE")
     */
    public function create(): Response
    {
        return new Response('Страница создания статьи');
    }

    /**
     * @Route("/admin/articles/{id}/edit", name="app_admin_article_edit")
     * @IsGranted ("MANAGE", subject="article")
     */
    public function edit(Article $article): Response
    {
        return new Response('Страница редактирования статьи '.$article->getTitle());
    }
}
