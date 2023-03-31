<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleLikeController extends AbstractController
{
    /**
     * @Route("/articles/{slug}/vote/{type<up|down>}", name="app_article_vote")
     */
    public function typeVote(Article $article, EntityManagerInterface $em, $type)
    {
        if ($type === 'up') {
            $article->up();
        } else {
            $article->down();
        }
        $em->flush();
        return $this->json(['votes' => $article->getVoteCount()]);
    }

}
