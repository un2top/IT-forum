<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Homework\ArticleProvider;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleProvider $provider)
    {
        return $this->render('articles/homepage.html.twig',['articles'=>$provider->articles()]);
    }

    /**
     * @Route("/articles/{slug}", name="app_article_show")
     */
    public function show(ArticleProvider $provider)
    {

        $comments = ['Барон Сосискин' => 'Cur hippotoxota trabem?', 'Граф Колбаскин' => 'Pol, sensorem!',
            'Герцог Сарделька' => 'Cur orgia potus?', 'Дон Блинчик' => 'Pol, a bene gallus, cedrium!',
            'Душистый Перец' => 'A falsis, diatria flavum tabes.'];

        return $this->render('articles/show.html.twig', ['rand_article' => $provider->article(), 'comments' => $comments]);
    }


}