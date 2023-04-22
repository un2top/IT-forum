<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\User;
use App\Form\ArticleFormType;
use App\Homework\ArticleWordsFilter;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method User|null getUser()
 */
class ArticleController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     * @Route("admin/articles", name="app_admin_articles")
     */
    public function index(ArticleRepository $articleRepository, Request $request, PaginatorInterface $paginator)
    {

        $pagination = $paginator->paginate(
            $articleRepository->findAllWithSearchQuery($request->query->get('q')),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 20)
        );
        return $this->render('admin/article/index.html.twig', ['pagination'=>$pagination]);
    }

    /**
     * @Route("/admin/articles/create", name="app_admin_article_create")
     * @IsGranted ("ROLE_ADMIN_ARTICLE")
     */
    public function create(EntityManagerInterface $em, Request $request, ArticleWordsFilter $filter): Response
    {
        $form = $this->createForm(ArticleFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Article $article */
            $article = $form->getData();
            $article->setDescription($filter->filter($article->getDescription(), $filter->words));
            $article->setBody($filter->filter($article->getBody(), $filter->words));
            $em->persist($article);
            $em->flush();
            $this->addFlash('flash_message', 'Статья успешно создана');
            return $this->redirectToRoute('app_admin_articles');
        }

        return $this->render('admin/article/create.html.twig', ['articleForm' => $form->createView(),'show_Error'=>$form->isSubmitted(),]);
    }

    /**
     * @Route("/admin/articles/{id}/edit", name="app_admin_article_edit")
     * @IsGranted ("MANAGE", subject="article")
     */
    public function edit(Article $article, EntityManagerInterface $em, Request $request, ArticleWordsFilter $filter): Response
    {
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Article $article */
            $article = $form->getData();
            $article->setDescription($filter->filter($article->getDescription(), $filter->words));
            $article->setBody($filter->filter($article->getBody(), $filter->words));
            $em->persist($article);
            $em->flush();
            $this->addFlash('flash_message', 'Статья успешно изменена');
            return $this->redirectToRoute('app_admin_article_edit', ['id'=>$article->getId()]);
        }
        return $this->render('admin/article/edit.html.twig', ['articleForm' => $form->createView(), 'show_Error'=>$form->isSubmitted(),]);
    }
}
