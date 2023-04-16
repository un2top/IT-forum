<?php

namespace App\Controller\Api;

use App\Entity\ApiToken;
use App\Entity\User;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 * @method User|null getUser()
 * @method ApiToken|null getToken()
 */
class UserController extends AbstractController
{
    /**
     * @Route("/api/v1/user", name="api_user")
     */
    public function index(LoggerInterface $apiLogger): Response
    {
        return $this->json($this->getUser(), 200, [], ['groups' => ['main']]);
    }
}
