<?php

namespace App\Controller;

use App\Homework\ArticleContentProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Homework\ArticleProvider;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleProvider $provider)
    {
        return $this->render('articles/homepage.html.twig', ['articles' => $provider->articles()]);
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
    public function show(ArticleProvider $provider, ArticleContentProvider $articleContentProvider)
    {

        $comments = ['Барон Сосискин' => 'Cur hippotoxota trabem?', 'Граф Колбаскин' => 'Pol, sensorem!',
            'Герцог Сарделька' => 'Cur orgia potus?', 'Дон Блинчик' => 'Pol, a bene gallus, cedrium!',
            'Душистый Перец' => 'A falsis, diatria flavum tabes.'];
        $words = ['новости', 'политика', 'спорт', 'еда', 'девушки'];

        if (mt_rand(0, 100) >= 70) {
            $articleContent = $articleContentProvider->get(5, $words[array_rand($words, 1)], rand(1, 5));
        } else {
            $articleContent = $articleContentProvider->get(mt_rand(1, 5));
        }

        return $this->render('articles/show.html.twig', ['rand_article' => $provider->article(), 'comments' => $comments,
            'articleContent' => $articleContent]);
    }

}