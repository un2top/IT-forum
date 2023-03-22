<?php

namespace App\Controller;

use App\Homework\ArticleContentProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{
    /**
     * @Route("/api/v1/article_content", methods={"POST"})
     */
    public function getJson(Request $request, ArticleContentProvider $articleContentProvider){
        try {
            $data = $request->toArray();

            $textarr[]=['text'=>$articleContentProvider->get($data['paragraphs'],$data['word'], $data['wordCount'])];
            return new Response($this->json($textarr));

        } catch (Exception $jsonException){
            return $jsonException->getMessage("Файл не json формата");
        }

    }

}