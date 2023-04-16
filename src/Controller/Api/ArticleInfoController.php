<?php

namespace App\Controller\Api;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleInfoController extends AbstractController
{
    /**
     * @Route("/api/v1/artices/{id}", name="api_article_info")
     * @IsGranted ("API", subject="article")
     */
    public function index(Article $article): Response
    {
        return $this->json($article, 200, [], ['groups' => ['main']]);
    }
}
