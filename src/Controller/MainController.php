<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class MainController extends Controller
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        $user = $this->getUser();

        if ($user instanceof UserInterface) {
            return $this->redirectToRoute('user_profile');
        }

        return $this->render('main.html.twig');
    }
}
