<?php

namespace App\Controller\Admin;

use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentsController extends AbstractController
{
    /**
     * @Route("/admin/comments", name="app_admin_comments")
     */
    public function index(Request $request, CommentRepository $commentRepository, PaginatorInterface $paginator)
    {

        $comments = $commentRepository->findAllWithSearchQuery(
            $request->query->get('q'),
            $request->query->has('showDeleted')
        );
        $countString = 20;
        if ($request->query->get('count')) {
            $countString = $request->query->get('count');
        }

        $pagination = $paginator->paginate(
            $comments, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            $countString /*limit per page*/
        );

        return $this->render('admin/comments/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
