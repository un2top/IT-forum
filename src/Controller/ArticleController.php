<?php

namespace App\Controller;

use App\Entity\Article;
use App\Homework\ArticleContentProvider;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository)
    {
        $articles = $repository->findLatestPublished();

        return $this->render('articles/homepage.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/articles/article_content", name="app_article_content")
     */
    public function articleContent(Request $request, ArticleContentProvider $articleContentProvider)
    {
        $colParagraph = $request->query->get('col_paragraph');
        $inputs = $request->query->get('inputs');
        $colRepeat = $request->query->get('col_repeat');
        $articleContent = $articleContentProvider->get($colParagraph, $inputs, $colRepeat);
        return $this->render('articles/article_content.html.twig', ['articleContent' => $articleContent]);
    }

    /**
     * @Route("/articles/{slug}", name="app_article_show")
     */
    public function show(Article $article)
    {

        $comments = ['Барон Сосискин' => 'Cur hippotoxota trabem?', 'Граф Колбаскин' => 'Pol, sensorem!',
            'Герцог Сарделька' => 'Cur orgia potus?', 'Дон Блинчик' => 'Pol, a bene gallus, cedrium!',
            'Душистый Перец' => 'A falsis, diatria flavum tabes.'];

        return $this->render('articles/show.html.twig', ['article' => $article, 'comments' => $comments]);
    }

}
