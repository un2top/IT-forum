<?php

namespace App\Controller\Api;

use App\Homework\ArticleContentProviderInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted ("ROLE_API")
 */
class ArticleContentProviderController extends AbstractController
{
    //,
    /**
     * @var LoggerInterface
     */
    private $apiLogger;

    public function __construct(LoggerInterface $apiLogger)
    {
        $this->apiLogger = $apiLogger;
    }

    /**
     * @Route("/api/v1/article_content", name="api_aricle_content_provider", methods={"POST"})
     */

    public function index(Request $request, ArticleContentProviderInterface $articleContentProvider)
    {
        if(!in_array("ROLE_API",$this->getUser()->getRoles())){
            $this->apiLogger->warning(sprintf('Предупреждение, заходил %s', $this->getUser()->getUsername()));
        }

        $data = json_decode($request->getContent(), true);
        $paragraphs = (int) ($data['paragraphs'] ?? 0);
        $word = $data['word'] ?? null;
        $wordsCount = (int) ($data['wordsCount'] ?? 0);
        
        return $this->json([
            'text' => $articleContentProvider->get($paragraphs, $word, $wordsCount),
        ]);
    }
}
