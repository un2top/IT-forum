<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentsController extends AbstractController
{
    /**
     * @Route("/admin/comments", name="app_admin_comments")
     */
    public function index(Request $request)
    {

        $comments = [
            [
                'articleTitle' => 'Что делать, если надо верстать?',
                'comment' => 'Pess persuadere, tanquam ferox bursa. Credere aliquando ducunt ad camerarius detrius. Ecce. Ignigenas crescere, tanquam albus nuclear vexatum iacere.',
                'createdAt' => new \DateTime('-1 hours'),
                'authorName' => 'Сметанка',
            ],
            [
                'articleTitle' => 'Facebook ест твои данные',
                'comment' => 'As i have shaped you, so you must hurt one another.',
                'createdAt' => new \DateTime('-1 days'),
                'authorName' => 'Рыжий Бесстыжий',
            ],
            [
                'articleTitle' => 'Когда пролил кофе на клавиатуру',
                'comment' => 'Big passions lead to the life. Placidus ignigena sapienter falleres competition est. A falsis, tumultumque audax armarium.',
                'createdAt' => new \DateTime('-11 days'),
                'authorName' => 'Барон Сосискин',
            ],
            [
                'articleTitle' => 'Что делать, если хочется спать?',
                'comment' => 'The sea-dog waves adventure like a swashbuckling jack.',
                'createdAt' => new \DateTime('-35 days'),
                'authorName' => 'Лучший прогер',
            ],
            [
                'articleTitle' => 'Когда перепутал соусы',
                'comment' => 'Lorem ipsum новости dolor sit amet',
                'createdAt' => new \DateTime('-35 minutes'),
                'authorName' => 'Колбаскин',
            ],
        ];

        $q = $request->query->get('q');
        if ($q) {
            $comments = array_filter($comments, function ($comment) use ($q) {
                return strpos($comment['comment'], $q) !== false;
            });
        }


        return $this->render('admin/comments/index.html.twig', [
            'comments' => $comments,
        ]);
    }
}
