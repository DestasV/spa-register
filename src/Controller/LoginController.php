<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="user_login")
     *
     * @param Request             $request
     * @param AuthenticationUtils $authUtils
     *
     * @return JsonResponse
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(['status' => 'error'], 400);
        }

        $error = $authUtils->getLastAuthenticationError(true);
        $lastUsername = $authUtils->getLastUsername();

        if ($error) {
            $response = new JsonResponse([
                'form' => $this->renderView('login/login.html.twig', [
                    'last_username' => $lastUsername,
                    'error' => $error,
                ])
            ], 400);

            return $response;
        }

        $response = new JsonResponse([
            'form' => $this->renderView('login/login.html.twig',
                array(
                    'last_username' => $lastUsername,
                    'error' => $error,
                ))], 200);

        return $response;
    }
}
