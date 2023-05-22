<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class PartialController extends AbstractController
{
    /**
     * @Route("/admin111/", name="app_admin1")
     */

    public function lastsComments(HttpKernelInterface $httpKernel)
    {
        $request = new Request();
        $request->attributes->set('_controller', 'App\\Controller\\PartialController::lastComments');
        /** @var JsonResponse $response */
        $response = $httpKernel->handle($request, HttpKernelInterface::SUB_REQUEST);
        $comments = [];
        if ($content = $response->getContent()){
            $comments = json_decode($content, true);
        }
        return $this->render('partial/last_comments.html.twig', ['comments' => $comments,]);
    }

    public function lastComments(CommentRepository $commentRepository)
    {
        $lastComments = $commentRepository->findThreeLatest();
        /** @var Comment $comment */
        foreach ($lastComments as $comment){
            $comments[] = ['content'=>$comment->getContent(), 'author'=>$comment->getAuthorName(), 'title'=>$comment->getArticle()->getTitle(),];
        }

        shuffle($comments);
        return $this->json($comments);
    }
}
